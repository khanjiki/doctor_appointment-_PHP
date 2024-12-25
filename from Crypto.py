from Crypto.Cipher import AES, DES
from Crypto.Util.Padding import pad, unpad
import binascii

# AES and DES keys (in hexadecimal)
aes_key_hex = '2b7e151628aed2a6abf7158809cf4f3c'
des_key_hex = '133457799bcdff1'
iv_hex = '0000000000000000'

# Convert hexadecimal keys to bytes
aes_key = binascii.unhexlify(aes_key_hex)
des_key = binascii.unhexlify(des_key_hex)
iv = binascii.unhexlify(iv_hex)

# Original plaintext message
plaintext = "Meet me at dawn"

# Encrypt using AES (ECB mode)
def encrypt_aes(plaintext, key):
    cipher = AES.new(key, AES.MODE_ECB)
    padded_data = pad(plaintext.encode(), AES.block_size)
    return cipher.encrypt(padded_data)

# Encrypt using DES (CBC mode)
def encrypt_des(data, key, iv):
    cipher = DES.new(key, DES.MODE_CBC, iv)
    return cipher.encrypt(pad(data, DES.block_size))

# Decrypt using DES (CBC mode)
def decrypt_des(ciphertext, key, iv):
    cipher = DES.new(key, DES.MODE_CBC, iv)
    return unpad(cipher.decrypt(ciphertext), DES.block_size)

# Decrypt using AES (ECB mode)
def decrypt_aes(ciphertext, key):
    cipher = AES.new(key, AES.MODE_ECB)
    return unpad(cipher.decrypt(ciphertext), AES.block_size)

# Encryption Process
# Step 1: Encrypt plaintext using AES
aes_ciphertext = encrypt_aes(plaintext, aes_key)

# Step 2: Encrypt the AES ciphertext using DES
des_ciphertext = encrypt_des(aes_ciphertext, des_key, iv)

# Decryption Process
# Step 1: Decrypt using DES
aes_ciphertext_decrypted = decrypt_des(des_ciphertext, des_key, iv)

# Step 2: Decrypt using AES
plaintext_decrypted = decrypt_aes(aes_ciphertext_decrypted, aes_key)

# Display results
print(f"Original plaintext: {plaintext}")
print(f"AES Ciphertext (hex): {binascii.hexlify(aes_ciphertext).decode()}")
print(f"DES Ciphertext (hex): {binascii.hexlify(des_ciphertext).decode()}")
print(f"Decrypted plaintext: {plaintext_decrypted.decode()}")
