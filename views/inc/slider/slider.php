<style type="text/css">
    .slider-swiper {
        padding: 20px 0px;
        background-color: #edebf2;
    }

    .swiper {
        width: 100%;
        padding: 0px 150px;

    }

    .swiper-wrapper {
        text-align: center;
    }

    .swiper-slide {
        background-position: center;
        background-size: cover;
    }

    .swiper-slide>img {
        width: 851px;
        height: 315px;
        border: 2px solid #f1f1f1;
        border-radius: 5px;
    }

    .swiper-button-prev {
        color: #DC555B;
    }

    .swiper-button-next {
        color: #DC555B;
    }

    .swiper-pagination {
        color: #DC555B;
    }

    @media screen and (max-width: 1024px) {
        .swiper {
            width: 100%;
            padding: 0px 100px;
        }

        .swiper-slide>img {
            width: 100%;
            height: 100%;
        }
    }

    @media screen and (max-width:600px) {
        .swiper {
            width: 100%;
            padding: 0px 20px;
        }

        .swiper-slide>img {
            width: 100%;
            height: 100%;
        }
    }
</style>
<section class="slider-swiper">
    <div class="container">
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php
                $Sql = "select * from slider order by id desc";
                $Stmt = fetch_data($connection, $Sql);
                if (mysqli_stmt_num_rows($Stmt) == 0) {
                    $noOrder = "Empty Teacher";
                } else {
                    mysqli_stmt_bind_result(
                        $Stmt,
                        $id,
                        $image,
                    );
                    $i = 1;
                    while (mysqli_stmt_fetch($Stmt)) { ?>
                        <div class="swiper-slide"><img src="<?= LINK; ?>public/images/<?= $image; ?>" alt="slide img" /></div>
                <?php }
                } ?>
            </div>
            <div class="swiper-pagination"></div>
            <!-- <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div> -->
        </div>
    </div>

</section>
<script type="text/javascript">
    const swiper = new Swiper('.swiper', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',

        coverflowEffect: {
            rotate: 20,
            stretch: 50,
            depth: 1000,
            modifier: 1,
            slideShows: false,
        },

        // Optional parameters
        direction: 'horizontal',
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        autoplay: {
            delay: 5000,
        },

        // Navigation arrows
        //   navigation: {
        //     nextEl: '.swiper-button-next',
        //     prevEl: '.swiper-button-prev',
        //   },


    });
</script>