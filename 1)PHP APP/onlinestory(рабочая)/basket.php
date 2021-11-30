<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="data:;base64,=">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:900%7CRoboto:300&display=swap&subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="css/basket.css?<?echo time();?>">

    <title>Online store</title>
</head>

<body>

    <!-- header-page -->
    <header class="header-page">
        <div class="container header-page__container">
            <div class="header-page__start">
                <div class="logo">
                    <div class="logo_text">Good Style</div>
                </div>
            </div>
            <div class="header-page__end">
                <nav class="header-page__nav">
                <ul class="header-page__ul">
                        <li class="header-page__li">
                            <a class="header-page__link" href="HomePage.php">
                                <span class="header-page__text">каталог</span>
                            </a>
                        </li>
                        <li class="header-page__li">
                            <a class="header-page__link" href="#" data-scroll-to="section-basket" >
                                <span class="header-page__text">корзина</span>
                            </a>
                        </li>
                        <li class="header-page__li">
                            <a class="header-page__link" href="#" data-scroll-to="section-about">
                                <span class="header-page__text">о нас</span>
                            </a>
                        </li>
                        <li class="header-page__li">
                            <a class="header-page__link" href="#" data-scroll-to="section-contacts">
                                <span class="header-page__text">контакты</span>
                            </a>
                        </li>
                     
                    </ul>
                </nav>
                <div class="phone">
                    <a class="phone__item header-page__phone" href="tel:+375256543130">+375 (25) 654-31-30</a>
                </div>
                <div class="header-page__hamburger">
                    <button class="btn-menu" type="button" data-popup="popup-menu">
          <span class="btn-menu__box">
            <span class="btn-menu__inner"></span>
          </span>
        </button>
                </div>
            </div>
        </div>
    </header>
    <!-- /.header-page -->

    <!-- section-catalog -->
    <section class="section section-basket">
        <div class="container">
        <h2 class="page-title page-title--accent">Корзина</h2>
            <div class="catalog">
            <?php
                 if(isset($_POST['deleteProduct'])){
                  
                    include "php/connection.php";
                    
                    $productId = $_POST["product_id"];
                    
                    
                    $queryDelete = "DELETE FROM basket WHERE id_product=".$productId." ;";
                    $resultDelete = mysqli_query($connection, $queryDelete) or die("Ошибка " . mysqli_error($connection));
    
                }

                if(isset($_POST['createOrder'])){
                    
                    include "php/connection.php";
                    session_start();
                    ob_start();
                    $querySumma = "SELECT ".
                    "SUM(p.price) as summa ".
                    "FROM basket as b ".
                    "LEFT JOIN product as p ON p.id_product = b.id_product;";
                    $resultSumma = mysqli_query($connection, $querySumma) or die("Ошибка " . mysqli_error($connection));
                    $rowSumma = mysqli_fetch_row($resultSumma);

                    $date= date("Y-m-d");

                    $queryOrder_user= "INSERT INTO order_user (id_order, `id_user`, `date_order`, `sum_price`) 
                    VALUES (NULL, '".$_SESSION['id_user']."', '".$date."', '".$rowSumma[0]."');";
                    $resultOrder_user = mysqli_query($connection, $queryOrder_user) or die("Ошибка " . mysqli_error($connection));
              
                    $queryOrder_userLast=" SELECT * FROM order_user ORDER BY id_order DESC LIMIT 1;";
                    $resultOrder_userLast = mysqli_query($connection, $queryOrder_userLast) or die("Ошибка " . mysqli_error($connection));
                    $rowOrder_userLast = mysqli_fetch_row($resultOrder_userLast);

                    $resultBasket = mysqli_query($connection, "SELECT * FROM basket") or die("Ошибка " . mysqli_error($connection));
                    while ($rowBasket = mysqli_fetch_row($resultBasket)){
                        $queryOrder_user= "INSERT INTO order_product (id_order, `id_product`) 
                        VALUES ('".$rowOrder_userLast[0]."', '".$rowBasket[1]."');";
                        $resultOrder_product = mysqli_query($connection, $queryOrder_user) or die("Ошибка " . mysqli_error($connection));
                    }

                    $queryDelete = "DELETE FROM basket;";
                    $resultDelete = mysqli_query($connection, $queryDelete) or die("Ошибка " . mysqli_error($connection));

    
                }
              include "php/connection.php";
              $query = "select p.id_product".
              ", c.name_category".
              ", p.price".
              ", p.link_to_picture".
              ", col.name_color".
              ", p.count_product".
              ", s.name_size".
              " from basket as b".
              " left join".
              " product as p".
              " on b.id_product = p.id_product".
              " left join".
              " color as col".
              " on p.id_color = col.id_color".
              " left join".
              " category as c".
              " on p.id_category = c.id_category".
              " left join".
              " size as s".
              " on p.id_size = s.id_size;";
              $result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection));
              if($result){
                while ($row = mysqli_fetch_row($result)) {
                echo '<div class="catalog__item" data-category="'.$row[1].'">';
                echo    '<div class="product catalog__product">';
                echo        '<picture>';
                echo            '<img class="product__img lazy"  src="'.$row[3].'" alt="">';
                echo        '</picture>';
                echo        '<div class="product__content">';
                echo        '<h3 class="product__title">'.$row[1].'</h3>';
                echo        '<p class="product__description">категория - '.$row[1].'</p>';
                echo        '<p class="product__description">цвет - '.$row[4].'</p>';
                echo        '<p class="product__description">размер - '.$row[6].'</p>';
                echo        '<p class="product__description">количество - '.$row[5].'</p>';
              
                echo     '</div>';
                echo     '<footer class="product__footer">';           
                echo        '<div class="product__bottom">';
                echo            '<div class="product__price">';
                echo                '<span class="product__price-value">'.$row[2].'</span>';
                echo                '<span class="product__currency">&#36;</span>';
                echo            '</div>';
                echo            ' <form action="" method="post">';
                echo                '<input type="hidden" name="product_id" value="'.$row[0].'">';
                echo                '<input type="submit" class="btn product__btn" id="deleteProduct" name="deleteProduct" data-popup="popup-order" value="Убрать из корзины">';
                echo            '</form>';
                echo         '</div>';
                echo      '</footer>';
                echo   '</div>';
                echo'</div>';
              }
            }
            
       
            ?> 
                
            </div>
            <form action="" method="post">
                    <input type="hidden" name="product_id" value="'.$row[0].'">
                    <input type="submit" class="btn product__btn" id="createOrder" name="createOrder" data-popup="popup-order" value="Сделать заказ">
                </form>
        </div>
    </section>
    <!-- /.section-catalog -->

    <!-- section-about -->
    <section class="section section-about">
        <picture>
            <img class="section-about__img lazy"  src="img/common/photo.jpg" alt="">
        </picture>
        <div class="container section-about__container">
            <div class="section-about__content">
                <h2 class="page-title section-about__title">О нас</h2>
                <p class="section-about__text">Мы предлагаем самые низкие цены, дешевле вы не найдете. Вашему вниманию самый широкий ассортимент товаров на всём рынке. Ждём вас за покупками каждый день, мы всегда к вашим услугам!</p>
            </div>
        </div>
    </section>
    <!-- /.section-about -->

    <!-- section-contacts -->
    <section class="section section-contacts">
        <div class="container section-contacts__container">
           
            <header class="section__header">
                <h2 class="page-title sectoin-contacts__title">Контакты</h2>
            </header>
            <div class="contacts">
                <div class="contacts__start">
                    <img src="img/common/contacts.jpg">
                </div>
                <div class="contacts__end">
                    <div class="contacts__item">
                        <h3 class="contacts__title">Адрес</h3>
                        <p class="contacts__text">г. Минск, ул. Одинцова 35</p>
                    </div>
                    <div class="contacts__item">
                        <h3 class="contacts__title">Телефон</h3>
                        <p class="contacts__text">
                            <a class="contacts__phone" href="tel:+79117112123">+375 (25) 654-31-30</a>
                        </p>
                    </div>
                    <div class="contacts__item">
                        <h3 class="contacts__title">Социальные сети</h3>
                        <ul class="socials">
                            <li class="socials__item">
                                <a href="#" class="socials__link" target="_blank">
                                    <svg class="socials__icon socials__icon--vk" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 112.2 112.2" width="35" height="35">
                  <g>
                    <circle cx="56.1" cy="56.1" r="56.1" />
                    <path class="socials__logo" d="M54,80.7h4.4a3.33,3.33,0,0,0,2-.9,3.37,3.37,0,0,0,.6-1.9s-.1-5.9,2.7-6.8,6.2,5.7,9.9,8.2c2.8,1.9,4.9,1.5,4.9,1.5l9.8-.1s5.1-.3,2.7-4.4c-.2-.3-1.4-3-7.3-8.5-6.2-5.7-5.3-4.8,2.1-14.7,4.5-6,6.3-9.7,5.8-11.3s-3.9-1.1-3.9-1.1l-11.1.1a2.32,2.32,0,0,0-1.4.3,3.58,3.58,0,0,0-1,1.2A60,60,0,0,1,70,50.9c-4.9,8.4-6.9,8.8-7.7,8.3-1.9-1.2-1.4-4.9-1.4-7.5,0-8.1,1.2-11.5-2.4-12.4a17.68,17.68,0,0,0-5.2-.5c-4,0-7.3,0-9.2.9-1.3.6-2.2,2-1.6,2.1a5.05,5.05,0,0,1,3.3,1.6c1.1,1.5,1.1,5,1.1,5s.7,9.6-1.5,10.7c-1.5.8-3.5-.8-7.9-8.4a67.05,67.05,0,0,1-4-8.2,2.82,2.82,0,0,0-.9-1.2,5.13,5.13,0,0,0-1.7-.7l-10.5.1s-1.6,0-2.2.7,0,1.9,0,1.9,8.2,19.3,17.6,29c8.5,9,18.2,8.4,18.2,8.4Z" />
                  </g>
                </svg>
                                </a>
                            </li>
                            <li class="socials__item">
                                <a href="#" class="socials__link" target="_blank">
                                    <svg class="socials__icon socials__icon--fb" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 112.2 112.2" width="35" height="35">
                  <g>
                    <circle cx="56.1" cy="56.1" r="56.1" />
                    <path class="socials__logo" d="M70.2,58.3h-10V95H45V58.3H37.8V45.4H45V37.1c0-6,2.8-15.3,15.3-15.3H71.5V34.3H63.3c-1.3,0-3.2.7-3.2,3.5v7.6H71.4Z" />
                  </g>
                </svg>
                                </a>
                            </li>
                            <li class="socials__item">
                                <a href="#" class="socials__link" target="_blank">
                                    <svg class="socials__icon socials__icon--inst" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="35" height="35">
                  <g>
                    <path d="M332.3,136.2H179.7a44.21,44.21,0,0,0-44.2,44.2V333a44.21,44.21,0,0,0,44.2,44.2H332.3A44.21,44.21,0,0,0,376.5,333V180.4A44.21,44.21,0,0,0,332.3,136.2ZM256,336a79.3,79.3,0,1,1,79.3-79.3A79.42,79.42,0,0,1,256,336Zm81.9-142.2A18.8,18.8,0,1,1,356.7,175,18.78,18.78,0,0,1,337.9,193.8Z" />
                    <path d="M256,210.9a45.8,45.8,0,1,0,45.8,45.8A45.86,45.86,0,0,0,256,210.9Z" />
                    <path d="M256,0C114.6,0,0,114.6,0,256S114.6,512,256,512,512,397.4,512,256,397.4,0,256,0ZM410,333a77.78,77.78,0,0,1-77.7,77.7H179.7A77.78,77.78,0,0,1,102,333V180.4a77.84,77.84,0,0,1,77.7-77.7H332.3A77.84,77.84,0,0,1,410,180.4Z" />
                  </g>
                </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.section-contacts -->

    <!-- footer-page -->
    <footer class="footer-page">
        <div class="container">
            <div class="footer-page__text">Good Style</div>
        </div>
    </footer>
    <!-- /.footer-page -->


    <!-- popup-menu -->
    <div class="popup popup-menu">
        <div class="popup__wrapper">
            <div class="popup__inner">
                <div class="popup__content popup__content--fluid popup__content--centered">
                    <button class="btn-close popup__btn-close popup-close"></button>
                    <nav class="mobile-menu popup__mobile-menu">
                        <ul class="mobile-menu__ul">
                            <li class="mobile-menu__li">
                                <a class="mobile-menu__link popup-close" href="#" data-scroll-to="section-catalog">Каталог</a>
                            </li>
                            <li class="mobile-menu__li">
                                <a class="mobile-menu__link popup-close" href="#" data-scroll-to="section-about">О нас</a>
                            </li>
                            <li class="mobile-menu__li">
                                <a class="mobile-menu__link popup-close" href="#" data-scroll-to="section-contacts">Контакты</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="phone popup__phone">
                        <a class="phone__item phone__item--accent" href="tel:+375(25)654-31-30">+375 (25) 654-31-30</a>
                    </div>
                    <ul class="socials">
                        <li class="socials__item">
                            <a href="#" class="socials__link" target="_blank">
                                <svg class="socials__icon socials__icon--vk" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 112.2 112.2" width="35" height="35">
                <g>
                  <circle cx="56.1" cy="56.1" r="56.1" />
                  <path class="socials__logo" d="M54,80.7h4.4a3.33,3.33,0,0,0,2-.9,3.37,3.37,0,0,0,.6-1.9s-.1-5.9,2.7-6.8,6.2,5.7,9.9,8.2c2.8,1.9,4.9,1.5,4.9,1.5l9.8-.1s5.1-.3,2.7-4.4c-.2-.3-1.4-3-7.3-8.5-6.2-5.7-5.3-4.8,2.1-14.7,4.5-6,6.3-9.7,5.8-11.3s-3.9-1.1-3.9-1.1l-11.1.1a2.32,2.32,0,0,0-1.4.3,3.58,3.58,0,0,0-1,1.2A60,60,0,0,1,70,50.9c-4.9,8.4-6.9,8.8-7.7,8.3-1.9-1.2-1.4-4.9-1.4-7.5,0-8.1,1.2-11.5-2.4-12.4a17.68,17.68,0,0,0-5.2-.5c-4,0-7.3,0-9.2.9-1.3.6-2.2,2-1.6,2.1a5.05,5.05,0,0,1,3.3,1.6c1.1,1.5,1.1,5,1.1,5s.7,9.6-1.5,10.7c-1.5.8-3.5-.8-7.9-8.4a67.05,67.05,0,0,1-4-8.2,2.82,2.82,0,0,0-.9-1.2,5.13,5.13,0,0,0-1.7-.7l-10.5.1s-1.6,0-2.2.7,0,1.9,0,1.9,8.2,19.3,17.6,29c8.5,9,18.2,8.4,18.2,8.4Z" />
                </g>
              </svg>
                            </a>
                        </li>
                        <li class="socials__item">
                            <a href="#" class="socials__link" target="_blank">
                                <svg class="socials__icon socials__icon--fb" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 112.2 112.2" width="35" height="35">
                <g>
                  <circle cx="56.1" cy="56.1" r="56.1" />
                  <path class="socials__logo" d="M70.2,58.3h-10V95H45V58.3H37.8V45.4H45V37.1c0-6,2.8-15.3,15.3-15.3H71.5V34.3H63.3c-1.3,0-3.2.7-3.2,3.5v7.6H71.4Z" />
                </g>
              </svg>
                            </a>
                        </li>
                        <li class="socials__item">
                            <a href="#" class="socials__link" target="_blank">
                                <svg class="socials__icon socials__icon--inst" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="35" height="35">
                <g>
                  <path d="M332.3,136.2H179.7a44.21,44.21,0,0,0-44.2,44.2V333a44.21,44.21,0,0,0,44.2,44.2H332.3A44.21,44.21,0,0,0,376.5,333V180.4A44.21,44.21,0,0,0,332.3,136.2ZM256,336a79.3,79.3,0,1,1,79.3-79.3A79.42,79.42,0,0,1,256,336Zm81.9-142.2A18.8,18.8,0,1,1,356.7,175,18.78,18.78,0,0,1,337.9,193.8Z" />
                  <path d="M256,210.9a45.8,45.8,0,1,0,45.8,45.8A45.86,45.86,0,0,0,256,210.9Z" />
                  <path d="M256,0C114.6,0,0,114.6,0,256S114.6,512,256,512,512,397.4,512,256,397.4,0,256,0ZM410,333a77.78,77.78,0,0,1-77.7,77.7H179.7A77.78,77.78,0,0,1,102,333V180.4a77.84,77.84,0,0,1,77.7-77.7H332.3A77.84,77.84,0,0,1,410,180.4Z" />
                </g>
              </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.popup-menu -->

    <script src="https://unpkg.com/focus-visible@5.0.2/dist/focus-visible.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.4.0/dist/lazyload.min.js"></script>

    <script src="js/main.js"></script>
</body>

</html>