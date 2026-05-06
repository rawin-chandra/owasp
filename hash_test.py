import hashlib
import os

def hash_password(password):
    # สร้าง Salt แบบสุ่มขนาด 16 byte
    salt = b'1234567890123456'
    #salt = os.urandom(16) 
    
    # ผสม Salt กับ Password แล้วทำการ Hash
    # การใช้ pbkdf2_hmac จะช่วยชะลอการเดาสุ่ม (Brute-force) ได้ดีขึ้น
    hash_value = hashlib.pbkdf2_hmac(
        'sha256', 
        password.encode('utf-8'), 
        salt, 
        100000  # จำนวนรอบในการวนลูป Hash (Iterations)
    )
    
    return salt, hash_value

# ทดลองใช้งาน
password_to_test = "password123"
salt, hashed_pw = hash_password(password_to_test)

print(f"Salt (Hex): {salt.hex()}")
print(f"Hashed (Hex): {hashed_pw.hex()}")
