import requests

def sendData(mejaId, durasi):
    u = 'http://localhost/dsky-admin-kasir/public/api/sensor/store'
    br = {'id_meja': mejaId, 'duration': round(durasi, 2)}
    r = requests.post(u, br)
    print(br)
    print(r.json())

sendData(1, 100)
