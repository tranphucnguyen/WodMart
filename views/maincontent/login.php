<?php
require_once 'vendor/autoload.php';

use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;
// init configuration
$clientID = '785569874049-hrh58315ofbhvpo4qu8gd3u8r0b8c6vj.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/thuongmaidientu/index.php?quanly=Login';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;

    // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu hay chưa
    $stmt = $conn->prepare("SELECT * FROM tbl_account_customers WHERE email_customer = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Người dùng đã tồn tại, lấy username từ cơ sở dữ liệu
        $user_data = $result->fetch_assoc();
        $username = $user_data['username_customer'];
        $id_account_customer = $user_data['id_account_customer'];
        $_SESSION['email_customer'] = $email;
        $_SESSION['username_customer'] = $username;
        $_SESSION['id_account_customer'] = $id_account_customer; // Lưu id vào session
        // Echo ra id_account_customer
        echo "<script>console.log('ID Account Customer: " . $id_account_customer . "');</script>";
    } else {
        // Người dùng chưa tồn tại, đẩy thông tin lên cơ sở dữ liệu
        $username = explode('@', $email)[0];
        $stmt_insert = $conn->prepare("INSERT INTO tbl_account_customers (username_customer, email_customer, account_status) VALUES (?, ?, 1)");
        $stmt_insert->bind_param("ss", $username, $email);

        if ($stmt_insert->execute()) {
            echo "Đăng nhập và đăng ký thành công bằng Google.";
            // Lấy id_account_customer của người dùng vừa tạo
            $id_account_customer = $stmt_insert->insert_id;
            $_SESSION['email_customer'] = $email;
            $_SESSION['username_customer'] = $username;
            $_SESSION['id_account_customer'] = $id_account_customer; // Lưu id vào session
            // Echo ra id_account_customer
            echo "<script>console.log('ID Account Customer: " . $id_account_customer . "');</script>";
        } else {
            echo "Lỗi khi đăng nhập và đăng ký: " . $stmt_insert->error;
            var_dump($stmt_insert);
        }

        $stmt_insert->close();
    }

    $stmt->close();
    $conn->close();
    // Sử dụng JavaScript để redirect, giữ nguyên đường dẫn gốc
    echo "<script>window.location.href = 'index.php?quanly=Login';</script>";
} else {
?>
    <section class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Login</h1>
                        <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                            <ul class="breadcrumb listing">
                                <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                                </li>
                                <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)" class="single active">Login</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of Breadcrumbs-->
    <!-- Login area S t a r t  -->
    <div class="login-area section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
                    <div class="login-card">
                        <!-- Form -->
                        <form action="controllers/LoginSignupController.php" method="POST">
                            <div class="position-relative contact-form mb-24">
                                <label class="contact-label">Email </label>
                                <input class="form-control contact-input" name="email_customer" type="text" placeholder="Enter Your Email" required>
                            </div>

                            <div class="contact-form mb-24">
                                <div class="position-relative ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="contact-label">Password</label>
                                        <a href="index.php?quanly=Forgot_password"><span class="text-primary text-15">
                                                Forgot password?
                                            </span></a>
                                    </div>
                                    <input type="password" name="password_customer" class="form-control contact-input password-input" id="txtPasswordLogin" placeholder="Enter Password" required>
                                    <i class="toggle-password ri-eye-line"></i>
                                </div>
                            </div>

                            <button type="submit" name="Login" class="btn-primary-fill justify-content-center w-100">
                                <span class="d-flex justify-content-center gap-6">
                                    <span>Login</span>
                                </span>
                            </button>
                        </form>


                        <div class="login-footer">
                            <div class="create-account">
                                <p>
                                    Don’t have an account?
                                    <a href="index.php?quanly=Signup">
                                        <span class="text-primary">Register</span>
                                    </a>
                                </p>
                            </div>
                            <a href="<?php echo $client->createAuthUrl() ?>" class="login-btn d-flex align-items-center justify-content-center gap-10">
                                <img src="assets/images/icon/google-icon.png" alt="img" class="m-0">
                                <span> login with Google</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<!--/ End-of Login -->