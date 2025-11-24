<style>
        /* Sidebar container */
        .sidebar-container {
            font-family: "Poppins", sans-serif;
            background: #fff;
            width: 280px;
            height: 100vh;
            padding: 20px;
            box-shadow: 2px 0 12px rgba(0,0,0,0.08);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        .sidebar-header img {
            width: 60px;
            height: 60px;
        }
        .sidebar-header span {
            font-weight: 600;
            font-size: 18px;
            color: #2c3e50;
            line-height: 1.2;
        }

        /* Profile section */
        .profile-wrapper {
            position: relative;
        }

        .profile-card {
            background: #f8f9fb;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            cursor: pointer;
            transition: background 0.2s;
        }
        .profile-card:hover {
            background: #eef3ff;
        }
        .profile-card img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        .profile-info strong {
            font-size: 14px;
            color: #2c3e50;
        }
        .profile-info small {
            color: #6c757d;
            font-size: 12px;
        }

        .profile-dropdown {
            position: absolute;
            top: 70px;
            left: 0;
            background: #fff;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            border-radius: 10px;
            overflow: hidden;
            display: none;
            animation: fadeIn 0.2s ease-in-out;
            z-index: 10;
        }

        .profile-dropdown a {
            display: block;
            padding: 10px 14px;
            text-decoration: none;
            color: #2c3e50;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            transition: 0.2s;
        }

        .profile-dropdown a:last-child {
            border-bottom: none;
        }

        .profile-dropdown a:hover {
            background: #545DB0;
            color: #fff;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .menu-section {
            margin-bottom: 20px;
        }
        .menu-title {
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
            color: #7f8c8d;
            margin: 15px 10px 5px;
        }
        .menu a {
            display: block;
            text-decoration: none;
            color: #2c3e50;
            margin: 4px 10px;
            font-size: 15px;
            padding: 10px 14px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .menu a:hover, 
        .menu a.active {
            background: #545DB0;
            color: #fff;
            box-shadow: 0 2px 6px rgba(84,93,176,0.3);
        }

        .logout {
            margin-top: 10px;
            text-align: center;
        }
        .logout a {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
        }
        .logout a:hover {
            background: #c0392b;
        }
    </style>