<header>
    <div class="header-area">
        <div class="main-header">
            <div class="top-menu-wrapper d-none d-lg-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center justify-content-between">
                                <!-- Top Left Side -->
                                <div class="top-header-left d-flex align-items-center">
                                    <div class="top-menu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="13"
                                            viewBox="0 0 18 13" fill="none">
                                            <path
                                                d="M17.2021 1.33173C17.2021 4.77563 17.2021 8.21953 17.2021 11.6634C17.198 11.6718 17.1897 11.6843 17.1897 11.6926C17.0691 12.4941 16.3995 13.0243 15.5511 12.9992C14.8108 12.9784 14.0664 12.9951 13.3261 12.9951C9.47914 12.9951 5.63219 12.9951 1.78525 12.9951C0.86198 12.9951 0.20488 12.3606 0.20488 11.4547C0.200721 8.15274 0.200721 4.8466 0.209039 1.54045C0.209039 1.31086 0.267263 1.06039 0.362917 0.851674C0.64572 0.258906 1.1531 9.15527e-05 1.80188 9.15527e-05C6.40158 9.15527e-05 11.0013 9.15527e-05 15.5968 9.15527e-05C15.6343 9.15527e-05 15.6758 9.15527e-05 15.7133 9.15527e-05C16.1874 0.0209637 16.5783 0.204638 16.8778 0.576162C17.0607 0.801581 17.1398 1.06457 17.2021 1.33173ZM1.91417 1.0103C4.20155 3.28536 6.45981 5.53537 8.70559 7.76452C10.9597 5.50198 13.2013 3.25197 15.4388 1.0103C10.9555 1.0103 6.45565 1.0103 1.91417 1.0103ZM15.443 11.989C13.8709 10.4111 12.2905 8.82482 10.706 7.23436C10.6769 7.26359 10.6311 7.30533 10.5896 7.34707C10.1154 7.82296 9.64134 8.29884 9.16723 8.77055C8.86363 9.07528 8.60994 9.07528 8.29803 8.76638C7.81144 8.28214 7.32485 7.79791 6.83826 7.3095C6.79668 7.26776 6.77588 7.20097 6.75925 7.17592C5.12897 8.8123 3.54445 10.4028 1.96408 11.989C6.44733 11.989 10.9514 11.989 15.443 11.989ZM1.21132 1.71578C1.21132 4.92173 1.21132 8.08595 1.21132 11.2543C2.80417 9.65553 4.3887 8.06925 5.98154 6.46627C4.40117 4.89251 2.81665 3.31458 1.21132 1.71578ZM11.4837 6.49967C13.0474 8.06925 14.6237 9.65135 16.1957 11.2293C16.1957 8.08177 16.1957 4.91339 16.1957 1.77005C14.6278 3.34798 13.0474 4.93008 11.4837 6.49967Z"
                                                fill="#AD8C5C" />
                                        </svg>
                                        <a href="javascript:void(0)">
                                            <?php if (isset($_SESSION['email_customer'])) : ?>
                                            <p class="pera text-color-secondary">
                                                <?php echo $_SESSION['email_customer']; ?></p>
                                            <?php else : ?>
                                            <p class="pera text-color-secondary">infoyour@gmail.com</p>
                                            <?php endif; ?>

                                        </a>
                                    </div>
                                </div>
                                <!--Top Right Side -->
                                <div class="top-header-right">
                                    <!-- login/register -->
                                    <div class="login-wrapper ml-48">
                                        <svg width="20" height="20" viewBox="0 0 26 26" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_366_11241)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13 1.75C6.7868 1.75 1.75 6.7868 1.75 13C1.75 16.0203 2.9395 18.7622 4.8774 20.7837C6.40175 17.853 9.4662 15.85 13 15.85C16.5338 15.85 19.5983 17.853 21.1226 20.7837C23.0605 18.7622 24.25 16.0203 24.25 13C24.25 6.7868 19.2132 1.75 13 1.75ZM19.9665 21.8341C18.762 19.188 16.0948 17.35 13 17.35C9.9052 17.35 7.23801 19.188 6.03354 21.8341C7.94968 23.3474 10.3686 24.25 13 24.25C15.6314 24.25 18.0503 23.3474 19.9665 21.8341ZM0.25 13C0.25 5.95837 5.95837 0.25 13 0.25C20.0416 0.25 25.75 5.95837 25.75 13C25.75 16.8422 24.0496 20.2881 21.3627 22.6245C19.1245 24.5709 16.199 25.75 13 25.75C9.80096 25.75 6.87546 24.5709 4.63726 22.6245C1.95044 20.2881 0.25 16.8422 0.25 13Z"
                                                    fill="black"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13 12.25C11.6193 12.25 10.5 11.1307 10.5 9.75C10.5 8.36929 11.6193 7.25 13 7.25C14.3807 7.25 15.5 8.36929 15.5 9.75C15.5 11.1307 14.3807 12.25 13 12.25ZM9 9.75C9 11.9591 10.7909 13.75 13 13.75C15.2091 13.75 17 11.9591 17 9.75C17 7.54086 15.2091 5.75 13 5.75C10.7909 5.75 9 7.54086 9 9.75Z"
                                                    fill="black"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_366_11241">
                                                    <rect width="26" height="26" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <a href="index.php?quanly=Login">
                                            <?php if (isset($_SESSION['username_customer'])) : ?>
                                            <p class="pera text-color-primary">
                                                <?php echo $_SESSION['username_customer']; ?></p>
                                            <a href="controllers/LoginSignupController.php?action=logout"><i
                                                    style="color: #7d7d7d ; "
                                                    class="fa-solid fa-arrow-right-from-bracket"></i></a>
                                            <?php else : ?>
                                            <p class="pera text-color-primary">Login/ Register</p>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include("menu.php");
            ?>
        </div>
        <!-- search overlay -->
        <div class="search-container">
            <div class="top-section">
                <div class="search-icon">
                    <i class="ri-search-line"></i>
                </div>
                <div class="modal-search-box">
                    <input type="text" id="searchField" class="search-field" placeholder="Search...">
                    <button id="closeSearch" class="close-search-btn">
                        <kbd class="light-text"> ESC </kbd>
                    </button>
                </div>
            </div>
            <div class="body-section">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="listing">
                            <li>
                                <h4 class="search-label">Recent</h4>
                            </li>
                            <li class="single-list">
                                <a href="javascript:void(0)">
                                    <div class="search-flex">
                                        <div class="content-img">
                                            <img src="assets/images/news/news-1.png" alt="img">
                                        </div>
                                        <div class="content">
                                            <h4 class="title line-clamp-1">
                                                Modern studio apartment design bedroom and living space
                                            </h4>
                                            <p class="pera line-clamp-2">
                                                Wonderful evening escapade starting at Madinat
                                                Jumeirah to the musical fountains to see
                                                another. Wonderful evening escapade starting at
                                                Madinat Jumeirah to the musical fountains to see
                                                another
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="single-list">
                                <a href="javascript:void(0)">
                                    <div class="search-flex">
                                        <div class="content-img">
                                            <img src="assets/images/news/news-2.png" alt="img">
                                        </div>
                                        <div class="content">
                                            <h4 class="title line-clamp-1">
                                                Comfortable armchair in a room decorated
                                            </h4>
                                            <p class="pera line-clamp-2">
                                                Give a great end to your day in Dubai with our
                                                premium evening Red Dune Desert Safari. Give a
                                                great end to your day in Dubai with our premium
                                                evening Red Dune Desert Safari.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="single-list">
                                <a href="javascript:void(0)">
                                    <div class="search-flex">
                                        <div class="content-img">
                                            <img src="assets/images/news/news-3.png" alt="img">
                                        </div>
                                        <div class="content">
                                            <h4 class="title line-clamp-1">
                                                Cafe with coffee tables as sofas plants and shelves
                                            </h4>
                                            <p class="pera line-clamp-2">
                                                Admission to Dubai’s biggest, multicultural
                                                festival park with replicas of iconic landmarks.
                                                Admission to Dubai’s biggest, multicultural
                                                festival park with replicas of iconic landmarks
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <h4 class="search-label">Recent</h4>
                            </li>
                            <li class="single-list">
                                <a href="javascript:void(0)">
                                    <div class="search-flex">
                                        <div class="content-img">
                                            <img src="assets/images/news/news-1.png" alt="img">
                                        </div>
                                        <div class="content">
                                            <h4 class="title line-clamp-1">
                                                Modern studio apartment design bedroom and living space
                                            </h4>
                                            <p class="pera line-clamp-2">
                                                Wonderful evening escapade starting at Madinat
                                                Jumeirah to the musical fountains to see
                                                another. Wonderful evening escapade starting at
                                                Madinat Jumeirah to the musical fountains to see
                                                another
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="single-list">
                                <a href="javascript:void(0)">
                                    <div class="search-flex">
                                        <div class="content-img">
                                            <img src="assets/images/news/news-2.png" alt="img">
                                        </div>
                                        <div class="content">
                                            <h4 class="title line-clamp-1">
                                                Comfortable armchair in a room decorated
                                            </h4>
                                            <p class="pera line-clamp-2">
                                                Give a great end to your day in Dubai with our
                                                premium evening Red Dune Desert Safari. Give a
                                                great end to your day in Dubai with our premium
                                                evening Red Dune Desert Safari.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="single-list">
                                <a href="javascript:void(0)">
                                    <div class="search-flex">
                                        <div class="content-img">
                                            <img src="assets/images/news/news-3.png" alt="img">
                                        </div>
                                        <div class="content">
                                            <h4 class="title line-clamp-1">
                                                Cafe with coffee tables as sofas plants and shelves
                                            </h4>
                                            <p class="pera line-clamp-2">
                                                Admission to Dubai’s biggest, multicultural
                                                festival park with replicas of iconic landmarks.
                                                Admission to Dubai’s biggest, multicultural
                                                festival park with replicas of iconic landmarks
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="div">
                        <div class="filter_menu"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>