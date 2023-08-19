import schedule
import mysql.connector

# Local database configuration
local_db_config = {
    "user": "root",
    "password": "",
    "host": "localhost",
    "database": "datakasir"
}

# Remote database configuration
remote_db_config = {
    "user": "o2uclzz9a2namt2yemqf",
    "password": "pscale_pw_HFWNscT2YRF22m3tGzbFcxwp5xXgVo2yzgxqOQXLo51",
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

def retrieve_data_pesanan_detail(last_date_sync):
    local_connection = mysql.connector.connect(**local_db_config)

    try:
        cursor = local_connection.cursor(dictionary=True)
        cursor.execute('SELECT * FROM pesanan_detail WHERE updated_at > %s', (last_date_sync,))
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

def retrieve_data_order_biliard_detail(last_date_sync):
    local_connection = mysql.connector.connect(**local_db_config)

    try:
        cursor = local_connection.cursor(dictionary=True)
        cursor.execute('SELECT * FROM orderbiliarddetail WHERE updated_at > %s', (last_date_sync,))
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
                INSERT INTO pesanan (Id_pesanan, Id_meja, TotalItem, TotalHarga, Diskon, ppn, TotalBayar, Diterima, Kembali, status, customer, cabang_id, created_at, updated_at)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
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
                updated_at = VALUES(updated_at)
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
                item["updated_at"]
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

        for item in data:
            upsert_query = """
                INSERT INTO log_sensor (id_pesanan, duration, cabang_id, created_at)
                VALUES (%s, %s, %s, %s)
                ON DUPLICATE KEY UPDATE
                duration = VALUES(duration),
                cabang_id = VALUES(cabang_id),
                created_at = VALUES(created_at)
            """

            values = (
                item["id_pesanan"],
                item["duration"],
                item["cabang_id"],
                item["created_at"],
                item["subtotal"],
                item["created_at"]
            )

            cursor.execute(upsert_query, values)
            print(f'Upserting data table log_sensor with id {item["id_pesanan"]}')

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


def upsert_to_remote_table_log_hapus_barang(data):
    connection = mysql.connector.connect(**remote_db_config)

    try:
        cursor = connection.cursor()

        total_data = 0  # Count the total number of upserted data

        for item in data:
            upsert_query = """
                INSERT INTO log_hapus_barang (id_meja, id_menu, harga, jumlah, subtotal, created_at, cabang_id, user_id)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
                ON DUPLICATE KEY UPDATE
                id_menu = VALUES(id_menu),
                harga = VALUES(harga),
                jumlah = VALUES(jumlah),
                subtotal = VALUES(subtotal),
                created_at = VALUES(created_at),
                cabang_id = VALUES(cabang_id),
                user_id = VALUES(user_id)
            """

            values = (
                item["id_meja"],
                item["id_menu"],
                item["harga"],
                item["jumlah"],
                item["subtotal"],
                item["created_at"],
                item["updated_at"],
                item["cabang_id"],
                item["user_id"]
            )

            cursor.execute(upsert_query, values)
            print(f'Upserting data table log_hapus_barang with id {item["id_meja"]}')

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
    if last_date_sync:
        # sync tabel pesanan
        data = retrieve_data(last_date_sync)
        if data:
            upsert_to_remote_table_pesanan(data)
        else:
            print('No new data to sync in table pesanan')

        # sync tabel log hapus barang
        data_log_hapus_barang = retrieve_data_log_hapus_barang(last_date_sync)
        if data_log_hapus_barang:
            upsert_to_remote_table_log_hapus_barang(data)
        else:
            print('No new data to sync in table log hapus barang')

        # sync tabel log hapus barang
        data_log_sensor = retrieve_data_log_sensor(last_date_sync)
        if data_log_sensor:
            upsert_to_remote_table_log_sensor(data)
        else:
            print('No new data to sync in table log hapus barang')

    else:
        print('Unable to fetch last sync date from remote database.')

perform_data_sync()
print('Data synchronization job started.')

# Schedule the data synchronization operation every minute
# schedule.every().minute.do(perform_data_sync)
