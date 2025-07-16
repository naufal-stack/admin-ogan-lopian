<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Memuat Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Menggunakan font Inter dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5; /* Warna latar belakang lembut */
        }
        /* Gaya untuk pesan notifikasi */
        .message-box {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none; /* Sembunyikan secara default */
            font-weight: 500;
        }
        .message-box.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="message-box" id="messageBox"></div>

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <!-- Tombol di atas telah dihapus -->

        <!-- Form Admin Login -->
        <form id="adminLoginForm" class="space-y-6">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Admin</h2>
            <div>
                <label for="admin_username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="admin_username" name="username" placeholder="Masukkan Username Admin Anda"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       required>
            </div>
            <div>
                <label for="admin_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="admin_password" name="password" placeholder="Masukkan Password Admin Anda"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       required>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300 shadow-md">
                Login
            </button>
        </form>
    </div>

    <script>
        const adminLoginForm = document.getElementById('adminLoginForm');
        const messageBox = document.getElementById('messageBox');

        // Fungsi untuk menampilkan pesan
        function showMessage(message, type = 'success') {
            messageBox.textContent = message;
            messageBox.className = `message-box ${type}`;
            messageBox.style.display = 'block';
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 5000); // Pesan akan hilang setelah 5 detik
        }

        // Event Listener untuk submit form Admin Login
        adminLoginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(adminLoginForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('http://127.0.0.1:8000/api/auth/admin/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.status) {
                    showMessage(result.message, 'success');
                    console.log('Admin Token:', result.data.token);
                    // Simpan token admin (misalnya di localStorage)
                    localStorage.setItem('admin_token', result.data.token);
                    // Redirect ke dashboard admin
                    window.location.href = 'http://127.0.0.1:8000/dasboard';
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Terjadi kesalahan saat login admin.', 'error');
            }
        });
    </script>
</body>
</html>
