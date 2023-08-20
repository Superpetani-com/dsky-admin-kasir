import tkinter as tk
from tkinter import messagebox, scrolledtext
from threading import Thread
import schedule
import time
import mysql.connector
import datetime

# Local database configuration
local_db_config = {
    "user": "root",
    "password": "",
    "host": "localhost",
    "database": "datakasir"
}

# Remote database configuration
remote_db_config = {
    "user": "4v47wxw8tw4li5733mig",
    "password": "pscale_pw_Wfa1t6eYCFpCoDap6VImF1Z39eLD1rsF0JhxbAsr1LP",
    "host": "aws.connect.psdb.cloud",
    "database": "billiard",
    "connection_timeout": 1200
}

# Fetch the last sync date from the cron_history table in the remote database
def get_last_date_sync():
    connection = mysql.connector.connect(**remote_db_config)

    try:
        cursor = connection.cursor(dictionary=True)
        cursor.execute('SELECT last_date_sync FROM cron_history ORDER BY id DESC LIMIT 1')
        result = cursor.fetchone()
        if result:
            return result['last_date_sync']
        return None
    except mysql.connector.Error as error:
        print('Error fetching last sync date from remote database:', error)
        return None
    finally:
        connection.close()

def retrieve_data(last_date_sync):
    local_connection = mysql.connector.connect(**local_db_config)

    try:
        cursor = local_connection.cursor(dictionary=True)
        cursor.execute('SELECT * FROM pesanan WHERE updated_at > %s', (last_date_sync,))
        rows = cursor.fetchall()
        return rows
    except mysql.connector.Error as error:
        print('Error retrieving data from local database:', error)
        return []
    finally:
        local_connection.close()

def retrieve_data_log_hapus_barang(last_date_sync):
    local_connection = mysql.connector.connect(**local_db_config)

    try:
        cursor = local_connection.cursor(dictionary=True)
        cursor.execute('SELECT * FROM log_hapus_barang WHERE created_at > %s', (last_date_sync,))
        rows = cursor.fetchall()
        return rows
    except mysql.connector.Error as error:
        print('Error retrieving data from local database:', error)
        return []
    finally:
        local_connection.close()

def retrieve_data_log_sensor(last_date_sync):
    local_connection = mysql.connector.connect(**local_db_config)

    try:
        cursor = local_connection.cursor(dictionary=True)
        cursor.execute('SELECT * FROM log_sensor WHERE created_date > %s', (last_date_sync,))
        rows = cursor.fetchall()
        return rows
    except mysql.connector.Error as error:
        print('Error retrieving data from local database:', error)
        return []
    finally:
        local_connection.close()

def retrieve_data_order_biliard(last_date_sync):
    local_connection = mysql.connector.connect(**local_db_config)

    try:
        cursor = local_connection.cursor(dictionary=True)
        cursor.execute('SELECT * FROM order_biliard WHERE updated_at > %s', (last_date_sync,))
        rows = cursor.fetchall()
        return rows
    except mysql.connector.Error as error:
        print('Error retrieving data from local database:', error)
        return []
    finally:
        local_connection.close()

def upsert_to_remote_table_pesanan(data):
    connection = mysql.connector.connect(**remote_db_config)

    try:
        cursor = connection.cursor()

        total_data = 0  # Count the total number of upserted data

        for item in data:
            upsert_query = """
                INSERT INTO pesanan (Id_pesanan, Id_meja, TotalItem, TotalHarga, Diskon, ppn, TotalBayar, Diterima, Kembali, status, customer, cabang_id, created_at, updated_at, created_by)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                ON DUPLICATE KEY UPDATE
                Id_meja = VALUES(Id_meja),
                TotalItem = VALUES(TotalItem),
                TotalHarga = VALUES(TotalHarga),
                Diskon = VALUES(Diskon),
                ppn = VALUES(ppn),
                TotalBayar = VALUES(TotalBayar),
                Diterima = VALUES(Diterima),
                Kembali = VALUES(Kembali),
                status = VALUES(status),
                customer = VALUES(customer),
                cabang_id = VALUES(cabang_id),
                created_at = VALUES(created_at),
                updated_at = VALUES(updated_at),
                created_by = VALUES(created_by)
            """

            values = (
                item["Id_pesanan"],
                item["Id_meja"],
                item["TotalItem"],
                item["TotalHarga"],
                item["Diskon"],
                item["ppn"],
                item["TotalBayar"],
                item["Diterima"],
                item["Kembali"],
                item["status"],
                item["customer"],
                item["cabang_id"],
                item["created_at"],
                item["updated_at"],
                item["created_by"]
            )

            cursor.execute(upsert_query, values)
            print(f'Upserting data table pesanan with id {item["Id_pesanan"]}')

            total_data += 1

        # Insert into cron_history table
        insert_cron_history_query = """
            INSERT INTO cron_history (last_date_sync, total_data)
            VALUES (NOW(), %s)
        """
        cursor.execute(insert_cron_history_query, (total_data,))

        connection.commit()
        print(f'Bulk upsert operation successful. Total data upserted: {total_data}')
    except mysql.connector.Error as error:
        connection.rollback()
        print('Error performing bulk upsert:', error)
    finally:
        connection.close()

def upsert_to_remote_table_log_sensor(data):
    connection = mysql.connector.connect(**remote_db_config)

    try:
        cursor = connection.cursor()

        total_data = 0  # Count the total number of upserted data
        # Get the current UTC time
        current_time_utc = datetime.datetime.utcnow()

        # Calculate the GMT+7 offset in hours
        gmt_plus_7_offset = datetime.timedelta(hours=7)

        # Adjust the current time with the GMT+7 offset
        current_time_gmt_plus_7 = current_time_utc + gmt_plus_7_offset
        for item in data:
            upsert_query = """
                INSERT INTO log_sensor (id_log_sensor, id_meja, duration, cabang_id, created_date, created_by, last_sync)
                VALUES (%s, %s, %s, %s, %s, %s, %s)
                ON DUPLICATE KEY UPDATE
                id_log_sensor = VALUES(id_log_sensor),
                id_meja = VALUES(id_meja),
                duration = VALUES(duration),
                cabang_id = VALUES(cabang_id),
                created_date = VALUES(created_date),
                created_by = VALUES(created_by),
                last_sync = VALUES(last_sync)
            """

            values = (
                item["uuid"],
                item["id_meja"],
                item["duration"],
                item["cabang_id"],
                item["created_date"],
                item["created_by"],
                current_time_gmt_plus_7
            )

            cursor.execute(upsert_query, values)
            print(f'Upserting data table log_sensor with id {item["id_meja"]}')

            total_data += 1

        # Insert into cron_history table
        insert_cron_history_query = """
            INSERT INTO cron_history (last_date_sync, total_data)
            VALUES (%s, %s)
        """
        cursor.execute(insert_cron_history_query, (current_time_gmt_plus_7, total_data))

        connection.commit()
        print(f'Bulk upsert operation successful. Total data upserted: {total_data}')
    except mysql.connector.Error as error:
        connection.rollback()
        print('Error performing bulk upsert:', error)
    finally:
        connection.close()


def upsert_to_remote_table_log_hapus_barang(data):
    connection = mysql.connector.connect(**remote_db_config)

    try:
        cursor = connection.cursor()

        total_data = 0  # Count the total number of upserted data

        for item in data:
            upsert_query = """
                INSERT INTO log_hapus_barang (id_pesanan, id_menu, harga, jumlah, subtotal, created_at, updated_at,  cabang_id, user_id, created_by)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                ON DUPLICATE KEY UPDATE
                id_pesanan = VALUES(id_pesanan),
                id_menu = VALUES(id_menu),
                harga = VALUES(harga),
                jumlah = VALUES(jumlah),
                subtotal = VALUES(subtotal),
                created_at = VALUES(created_at),
                updated_at = VALUES(updated_at),
                cabang_id = VALUES(cabang_id),
                user_id = VALUES(user_id),
                created_by = VALUES(created_by)
            """

            values = (
                item["id_pesanan"],
                item["id_menu"],
                item["harga"],
                item["jumlah"],
                item["subtotal"],
                item["created_at"],
                item["updated_at"],
                item["cabang_id"],
                item["user_id"],
                item["created_by"]
            )

            cursor.execute(upsert_query, values)
            print(f'Upserting data table log_hapus_barang with id {item["id_pesanan"]}')

            total_data += 1

        # Insert into cron_history table
        insert_cron_history_query = """
            INSERT INTO cron_history (last_date_sync, total_data)
            VALUES (NOW(), %s)
        """
        cursor.execute(insert_cron_history_query, (total_data,))

        connection.commit()
        print(f'Bulk upsert operation successful. Total data upserted: {total_data}')
    except mysql.connector.Error as error:
        connection.rollback()
        print('Error performing bulk upsert:', error)
    finally:
        connection.close()

# Get the last sync date from the remote database
last_date_sync = get_last_date_sync()
print(f'Last Date Syncronize: {last_date_sync}')

def perform_data_sync():
    print(last_date_sync, 'last sync date')
    if last_date_sync:
        print('Do sync...')
        # sync tabel pesanan
        data = retrieve_data(last_date_sync)
        if data:
            upsert_to_remote_table_pesanan(data)
        else:
            print('No new data to sync in table pesanan')

        # sync tabel log hapus barang
        data_log_hapus_barang = retrieve_data_log_hapus_barang(last_date_sync)
        if data_log_hapus_barang:
            upsert_to_remote_table_log_hapus_barang(data_log_hapus_barang)
        else:
            print('No new data to sync in table log hapus barang')

        # sync tabel log hapus barang
        data_log_sensor = retrieve_data_log_sensor(last_date_sync)
        if data_log_sensor:
            upsert_to_remote_table_log_sensor(data_log_sensor)
        else:
            print('No new data to sync in table log hapus barang')

    else:
        print('Unable to fetch last sync date from remote database.')

# perform_data_sync()
# GUI initialization
class DataSyncApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Data Synchronization")

        self.log_console = scrolledtext.ScrolledText(root, wrap=tk.WORD, height=10)
        self.log_console.pack()


        # Create labels to display last sync date
        self.last_sync_label = tk.Label(root, text="Last Sync Date:")
        self.last_sync_label.pack()

        self.last_sync_date_label = tk.Label(root, text="")
        self.last_sync_date_label.pack()

        # Create buttons to trigger data synchronization
        self.sync_pesanan_button = tk.Button(root, text="Sync Pesanan", command=self.sync_pesanan)
        self.sync_pesanan_button.pack()

        self.sync_log_hapus_barang_button = tk.Button(root, text="Sync Log Hapus Barang", command=self.sync_log_hapus_barang)
        self.sync_log_hapus_barang_button.pack()

        self.sync_log_sensor_button = tk.Button(root, text="Sync Log Sensor", command=self.sync_log_sensor)
        self.sync_log_sensor_button.pack()

        self.sync_all_button = tk.Button(root, text="Sync All", command=self.sync_all)
        self.sync_all_button.pack()

        # Schedule the data synchronization operation
        schedule.every(15).minutes.do(self.perform_data_sync)

        # Update last sync date and GUI
        self.update_last_sync_date()

        # Start the scheduling loop
        self.schedule_thread = Thread(target=self.run_schedule)
        self.schedule_thread.start()

        # Redirect stdout to the log console
        import sys
        sys.stdout = self.LogRedirector(self.log_console)

    class LogRedirector:
        def __init__(self, text_widget):
            self.text_widget = text_widget

        def write(self, message):
            self.text_widget.insert(tk.END, message)
            self.text_widget.see(tk.END)

    def run_schedule(self):
        while True:
            schedule.run_pending()
            time.sleep(1)

    def perform_data_sync(self):
        self.update_last_sync_date()
        perform_data_sync()

    def update_last_sync_date(self):
        last_date_sync = get_last_date_sync()
        if last_date_sync:
            self.last_sync_date_label.config(text=last_date_sync)
        else:
            self.last_sync_date_label.config(text="Not available")

    def sync_pesanan(self):
        data = retrieve_data(last_date_sync)
        if data:
            upsert_to_remote_table_pesanan(data)
            messagebox.showinfo("Sync Pesanan", "Sync completed.")
        else:
            messagebox.showinfo("Sync Pesanan", "No new data to sync.")

    def sync_log_hapus_barang(self):
        data = retrieve_data_log_hapus_barang(last_date_sync)
        if data:
            upsert_to_remote_table_log_hapus_barang(data)
            messagebox.showinfo("Sync Log Hapus Barang", "Sync completed.")
        else:
            messagebox.showinfo("Sync Log Hapus Barang", "No new data to sync.")

    def sync_log_sensor(self):
        data = retrieve_data_log_sensor(last_date_sync)
        if data:
            upsert_to_remote_table_log_sensor(data)
            messagebox.showinfo("Sync Log Sensor", "Sync completed.")
        else:
            messagebox.showinfo("Sync Log Sensor", "No new data to sync.")

    def sync_all(self):
        self.sync_pesanan()
        self.sync_log_hapus_barang()
        self.sync_log_sensor()

# Create the main application window
root = tk.Tk()
app = DataSyncApp(root)
root.mainloop()
