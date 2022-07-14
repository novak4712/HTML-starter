"use strict"
document.addEventListener("DOMContentLoaded", function () {
    const cookie = getCookie('allow-cookie');
    if (!cookie) {
        setTimeout(function () {
            $('.cookie-info').addClass('active');
        }, 1000)
    }
    /* const */
    const body = $('body');

    /*nav*/
    body.on('click', '.nav-burger', function () {
        $(this).toggleClass('active');
        $('nav').toggleClass('active');
    });

    body.on('click', '.nav-item', function () {
        $('.nav-burger').removeClass('active');
        $('nav').removeClass('active');
    });

    body.on('click', '.cookie-info-button', function () {
        document.cookie = "allow-cookie=true; max-age=2592000";
        $('.cookie-info').removeClass('active');
    });

    /* button-effects*/
    $(".ripple").on("click", function (event) {
        $(this).append("<span class='ripple-effect'>");
        $(this).find(".ripple-effect").css({
            left: event.pageX - $(this).position().left,
            top: event.pageY - $(this).position().top
        }).animate({
            opacity: 0,
        }, 1500, function () {
            $(this).remove();
        });
    });

    /*sliders*/
    $(".technology-slider").slick({
        infinite: true,
        slidesToShow: 8,
        slidesToScroll: 8,
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 6,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                }
            },
            {
                breakpoint: 576,
                settings: "unslick"
            },

        ]
    });
    $(".portfolio-slider").slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        arrows: true
    });

    /*form validate*/

    $("#form").validate({
        rules: {
            name: {
                required: true,
                maxlength: 50,

            },
            phone: {
                required: true,
                maxlength: 20,

            },
            email: {
                required: true,
                email: true
            },
            country: {
                maxlength: 20,
            },
            message: {
                required: true,
                maxlength: 1000,
            },
        },
        submitHandler: function (form) {
            sendMail(form);
        }

    });

    async function sendMail(form) {
        let msg = '';
        let status = '';
        $("#form").addClass('sending');
        const formData = new FormData(form);
        const response = await fetch('sendmail.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        console.log('data',data);
        msg = data.message;
        status = data.status;



        if (status === 'success') {
            form.reset();
        } else {

        }
        $(".response").html(msg);
        $(".response").addClass(status);


        $("#form").removeClass('sending');
    }

});

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
