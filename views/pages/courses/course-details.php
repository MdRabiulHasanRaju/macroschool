<?php
$title = "Macro School - Courses";
?>
<?php
include("../../inc/header.php");
?>

<style>
    #para {
        display: block;
    }

    .collapsed {
        display: none !important;
    }
</style>

<section class="container course-details">
    <div class="course-details-top">
        <h1>Macro School Shop</h1>
        <h2>Macro School Varsity Special Private Programme 2024</h2>
    </div>
    <div class="course-details-col">
        <div class="course-details-col-1">
            <h3>Faculties</h3>
            <div class="course-details-faculties">
                <div class="faculti-member">
                    <img src="public/images/sajjad.jpg" id="faculti-image">
                    <h5 class="teacher-name">Sajjad Alom</h5>
                    <h5 class="teacher-department">Physics</h5>
                </div>
                <div class="faculti-member">
                    <img src="public/images/sajjad.jpg" id="faculti-image">
                    <h5 class="teacher-name">Sajjad Alom</h5>
                    <h5 class="teacher-department">Physics</h5>
                </div>
                <div class="faculti-member">
                    <img src="public/images/sajjad.jpg" id="faculti-image">
                    <h5 class="teacher-name">Sajjad Alom</h5>
                    <h5 class="teacher-department">Physics</h5>
                </div>
            </div>
            <div class="course-details-about">
                <h3>কোর্সটি সম্পর্কে</h3>
                <p>আমাদের ছাত্র-ছাত্রীদের মধ্যে একটা ধারণা তৈরি হয়েছে যে, ভার্সিটিতে চান্স পেতে হলে ইঞ্জিনিয়ারিং বা মেডিকেল এর প্রস্তুতি থাকলে ভাল, কেননা সেখানে ডিপলি পড়ানো হয়৷ এই ধারণাটা ভুল নয়, কেননা বিভিন্ন জায়গায় ভার্সিটির পড়ানোগুলো surface লেভেলের হয়ে থাকে৷ তবে ACS এ এবার আমরা এই ধারণাকে পরিবর্তন করতে চাই। কারো যদি ভার্সিটি টার্গেট থাকে সে যেনো কেবল এখানে প্রস্তুতি নিয়েই চান্স পায় এরকম ব্যবস্থা করছি৷</p>
            </div>
            <div class="course-details-faq">
                <h3>সচরাচর জিজ্ঞাসা :</h3>
                <div class="course-details-faq-box">
                    <p onclick="collapse()"><img class="icon" src="public/images/icon/dropdown.png">কোর্সটি কীভাবে কিনবো?</p>
                    <div class="para" id="para">
                        <p>বি.দ্র. কেনার পূর্বে অবশ্যই এই ভিডিওটি দেখে নাও : </p>
                        <a href="https://www.youtube.com/watch?v=ji7epk_R20U" target="_blank" rel="noopener noreferrer">https://www.youtube.com/watch?v=ji7epk_R20U</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="course-details-col-2">
            <div class="course-box">
                <img src="public/images/Hm course 2.jpg">
                <div class="course-box-top">
                    <div class="total">
                    <img src="public/images/icon/people.png" alt="" class="icon">
                    <p>কোর্সটি করছেন <strong>5,000</strong></p>
                    </div>
                    <div class="time">
                    <img src="public/images/icon/time.png" alt="" class="icon">
                    <p>২৪ এর ডেন্টাল পরীক্ষা পর্যন্ত</p>
                    </div>

                </div>
                <div class="course-box-middle">
                    <p><img src="public/images/icon/ok.png" alt="" class="icon"> ক্লাস সংখ্যা ১২০+</p>
                    <p><img src="public/images/icon/ok.png" alt="" class="icon"> ক্লাস সংখ্যা ১২০+</p>
                    <p><img src="public/images/icon/ok.png" alt="" class="icon"> ক্লাস সংখ্যা ১২০+</p>
                    <p><img src="public/images/icon/ok.png" alt="" class="icon"> ক্লাস সংখ্যা ১২০+</p>
                    <p><img src="public/images/icon/ok.png" alt="" class="icon"> ক্লাস সংখ্যা ১২০+</p>
                </div>
                <div class="course-box-bottom">
                    <Button class="my-btn">Download Class Routine</Button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include("../../inc/footer.php");
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>