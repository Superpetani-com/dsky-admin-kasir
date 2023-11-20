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
    "database": "datakasir_v2"
}

# Remote database configuration
remote_db_config = {
    "user": "root",
    "password": "root_password",
    "host": "104.154.119.168",
    "database": "billiards",
    "connection_timeout": 1200
}

# Fetch the last sync date from the cron_history table in the remote database
def get_last_date_sync(table_name):
    connection = mysql.connector.connect(**remote_db_config)

    try:
        cursor = connection.cursor(dictionary=True)
        # Note: Use a tuple (table_name,) instead of just table_name
        cursor.execute('SELECT * FROM cron_history WHERE cabang_id = "XT Billiard" AND table_name = %s ORDER BY id DESC LIMIT 1', (table_name,))
        result = cursor.fetchone()

        if result:
            return result['last_date_sync'], "XT Billiard"
        return None
    except mysql.connector.Error as error:
        print('Error fetching last sync date from remote database:', error)
        return None
    finally:
        connection.close()

def retrieve_data(last_date_sync, cabang_id):
    local_connection = mysql.connector.connect(**local_db_config)

    try:
        cursor = local_connection.cursor(dictionary=True)
        cursor.execute('SELECT * FROM pesanan WHERE updated_at > %s AND cabang_id = %s', (last_date_sync, cabang_id))
        rows = cursor.fetchall()
        return rows
    except mysql.connector.Error as error:
        print('Error retrieving data from local database:', error)
        return []
    finally:
        local_connection.close()

def retrieve_data_order_biliard(last_date_sync, cabang_id):
    local_connection = mysql.connector.connect(**local_db_config)

    try:
        cursor = local_connection.cursor(dictionary=True)
        cursor.execute('SELECT * FROM order_biliard WHERE updated_at > %s AND cabang_id = %s', (last_date_sync, cabang_id))
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
                INSERT INTO pesanan (Id_pesanan, Id_meja, TotalItem, TotalHarga, Diskon, ppn, TotalBayar, Diterima, Kembali, status, customer, cabang_id, created_at, updated_at, created_by, uuid)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
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
                created_by = VALUES(created_by),
                uuid = VALUES(uuid)
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
                item["created_by"],
                item["uuid"]
            )

            cursor.execute(upsert_query, values)
            print(f'Upserting data table pesanan with id {item["Id_pesanan"]}')

            total_data += 1

         # Insert into cron_history table
        insert_cron_history_query = """
            INSERT INTO cron_history (last_date_sync, total_data, cabang_id, table_name)
            VALUES (DATE_ADD(NOW(), INTERVAL 7 HOUR), %s, %s, %s)
        """
        cursor.execute(insert_cron_history_query, (total_data, cabang_id, 'pesanan'))

        connection.commit()
        print(f'Bulk upsert operation successful. Total data upserted: {total_data}')
    except mysql.connector.Error as error:
        connection.rollback()
        print('Error performing bulk upsert:', error)
    finally:
        connection.close()

def upsert_to_remote_table_order_billiard(data):
    connection = mysql.connector.connect(**remote_db_config)

    try:
        cursor = connection.cursor()

        total_data = 0  # Count the total number of upserted data
        # print(data)
        for item in data:
            upsert_query = """
                INSERT INTO order_biliard (id_order_biliard, id_meja_biliard, totaljam, diskon, totalharga, totalflag, totalbayar, diterima, kembali, status, customer, cabang_id, created_at, updated_at, created_by, uuid, id_pesanan)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                ON DUPLICATE KEY UPDATE
                id_order_biliard = VALUES(id_order_biliard),
                id_meja_biliard = VALUES(id_meja_biliard),
                totaljam = VALUES(totaljam),
                diskon = VALUES(diskon),
                totalharga = VALUES(totalharga),
                totalflag = VALUES(totalflag),
                totalbayar = VALUES(totalbayar),
                diterima = VALUES(diterima),
                kembali = VALUES(kembali),
                status = VALUES(status),
                customer = VALUES(customer),
                cabang_id = VALUES(cabang_id),
                created_at = VALUES(created_at),
                updated_at = VALUES(updated_at),
                created_by = VALUES(created_by),
                created_by = VALUES(created_by),
                id_pesanan = VALUES(id_pesanan)
            """

            values = (
                item["id_order_biliard"],
                item["id_meja_biliard"],
                item["totaljam"],
                item["diskon"],
                item["totalharga"],
                item["totalflag"],
                item["totalbayar"],
                item["diterima"],
                item["kembali"],
                item["status"],
                item["customer"],
                item["cabang_id"],
                item["created_at"],
                item["updated_at"],
                item["created_by"],
                item["uuid"],
                item["id_pesanan"]
            )

            cursor.execute(upsert_query, values)
            print(f'Upserting data table order_billiard with id {item["id_order_biliard"]}')

            total_data += 1

        # Insert into cron_history table
        insert_cron_history_query = """
            INSERT INTO cron_history (last_date_sync, total_data, cabang_id, table_name)
            VALUES (DATE_ADD(NOW(), INTERVAL 7 HOUR), %s, %s, %s)
        """
        cursor.execute(insert_cron_history_query, (total_data, cabang_id, 'order_billiard'))

        connection.commit()
        print(f'Bulk upsert operation successful. Total data upserted: {total_data}')
    except mysql.connector.Error as error:
        connection.rollback()
        print('Error performing bulk upsert:', error)
    finally:
        connection.close()

# Get the last sync date from the remote database
last_date_sync_o, cabang_id = get_last_date_sync("order_billiard")
last_date_sync_p, cabang_id = get_last_date_sync("pesanan")
print(f'Last Date Syncronize Order: {last_date_sync_o}')
print(f'Last Date Syncronize Pesanan: {last_date_sync_p}')
print(f'Cabang ID Syncronize: {cabang_id}')

def perform_data_sync():
    print(last_date_sync_o, 'last sync date order')
    print(last_date_sync_p, 'last sync date pesanan')
    if last_date_sync_o:
        print('Do sync...')
        # sync tabel pesanan
        data = retrieve_data(last_date_sync_p, cabang_id)
        if data:
            upsert_to_remote_table_pesanan(data)
        else:
            print('No new data to sync in table pesanan')

         # sync tabel order billiard
        data_order_biliard = retrieve_data_order_biliard(last_date_sync_o, cabang_id)
        if data_order_biliard:
            upsert_to_remote_table_order_billiard(data_order_biliard)
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

        self.sync_billiard_button = tk.Button(root, text="Sync Order", command=self.sync_order_billiard)
        self.sync_billiard_button.pack()

        self.sync_all_button = tk.Button(root, text="Sync All", command=self.sync_all)
        self.sync_all_button.pack()

        # Schedule the data synchronization operation
        schedule.every(5).minutes.do(self.perform_data_sync)

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
        last_date_sync = get_last_date_sync('order_billiard')
        if last_date_sync:
            self.last_sync_date_label.config(text=last_date_sync)
        else:
            self.last_sync_date_label.config(text="Not available")

    def sync_pesanan(self):
        data = retrieve_data(last_date_sync_p, cabang_id)
        if data:
            upsert_to_remote_table_pesanan(data)
            messagebox.showinfo("Sync Pesanan", "Sync completed.")
        else:
            messagebox.showinfo("Sync Pesanan", "No new data to sync.")

    def sync_order_billiard(self):
        data = retrieve_data_order_biliard(last_date_sync_o, cabang_id)
        if data:
            upsert_to_remote_table_order_billiard(data)
            messagebox.showinfo("Sync Order Biliard", "Sync completed.")
        else:
            messagebox.showinfo("Sync Order Biliard", "No new data to sync.")

    def sync_all(self):
        self.sync_order_billiard()
        self.sync_pesanan()
        # self.sync_log_hapus_barang()
        # self.sync_log_sensor()

# Create the main application window
root = tk.Tk()
app = DataSyncApp(root)
root.mainloop()
