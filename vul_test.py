import requests

# สร้าง Session เพื่อเก็บ Cookies โดยอัตโนมัติ
session = requests.Session()

# URL ของหน้า Login และหน้าปลายทาง
login_url = "http://localhost/dashboard/login.php"
dashboard_url = "http://localhost/dashboard/index.html"

# ข้อมูลที่ต้องส่ง (ต้องสอดคล้องกับฟิลด์ 'name' ในฟอร์ม HTML)
payload = {
    'email': 'vichai54@example.com',
    'password': 'wSysIcK0ts',
    'csrf_token': 'extracted_token_if_needed' # บางระบบต้องการค่านี้
}

# กำหนด Headers เพื่อจำลองว่าเป็นเบราว์เซอร์จริง
headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
    'Referer': login_url # ช่วยระบุแหล่งที่มาตามมาตรฐาน Referer Header
}

try:
    # 1. ทำการส่งข้อมูล POST เพื่อ Login
    response = session.post(login_url, data=payload, headers=headers)

    #print("response = ",response.text)
   
    # ตรวจสอบว่า Login สำเร็จหรือไม่ (เช่น เช็คจากคำที่ปรากฏในหน้าเว็บ)
    if "สำเร็จ" in response.text:
        print("Login Successful!")
       
        # 2. เข้าถึงหน้า Dashboard โดยใช้ Session เดิม
        dashboard_res = session.get(dashboard_url)
        print("Dashboard Content:", dashboard_res.text[:100])
    else:
        print("Login Failed!")

except Exception as e:
    print(f"An error occurred: {e}")
