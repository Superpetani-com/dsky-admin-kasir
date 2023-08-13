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
    "user": "9egm7owdc6my3l6ffnsc",
    "password": "pscale_pw_PEFyiTlL1mIaS6ZT2VlSLfWyzjIctSXP3FCQKLOKyId",
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

def upsert_to_remote(data):
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

            print(item['Id_pesanan'])

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
print(last_date_sync)

def perform_data_sync():
    if last_date_sync:
        data = retrieve_data(last_date_sync)
        if data:
            upsert_to_remote(data)
            # Update the last sync date in the cron_history table
            # update_last_date_sync(last_date_sync)
        else:
            print('No new data to sync.')
    else:
        print('Unable to fetch last sync date from remote database.')

perform_data_sync()
print('Data synchronization job started.')

# Schedule the data synchronization operation every minute
# schedule.every().minute.do(perform_data_sync)
