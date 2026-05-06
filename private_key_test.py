from cryptography.hazmat.primitives import hashes
from cryptography.hazmat.primitives.asymmetric import rsa, padding

# --- 1. การสร้างกุญแจ (Key Generation) ---
# สร้าง Private Key
private_key = rsa.generate_private_key(
    public_exponent=65537,
    key_size=2048,
)
# สร้าง Public Key จาก Private Key
public_key = private_key.public_key()

# --- 2. การเข้ารหัส (Encryption) ---
# ใช้ Public Key ในการเข้ารหัสข้อมูล
message = b"Secret message for Teacher S"

ciphertext = public_key.encrypt(
    message,
    padding.OAEP(
        mgf=padding.MGF1(algorithm=hashes.SHA256()),
        algorithm=hashes.SHA256(),
        label=None
    )
)

print(f"Ciphertext (Hex): {ciphertext.hex()}")

# --- 3. การถอดรหัส (Decryption) ---
# ใช้ Private Key ในการถอดรหัสข้อมูลกลับมา
plaintext = private_key.decrypt(
    ciphertext,
    padding.OAEP(
        mgf=padding.MGF1(algorithm=hashes.SHA256()),
        algorithm=hashes.SHA256(),
        label=None
    )
)

print(f"Decrypted Message: {plaintext.decode('utf-8')}")
