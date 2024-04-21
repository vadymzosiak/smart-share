document.addEventListener('DOMContentLoaded', function() {

    var currentUrl = window.location.href;
    var smartBgColor = smartShareSettings.smartBgColor;
    var smartTextColor = smartShareSettings.smartTextColor;
    var smartDelay = smartShareSettings.smartDelay * 1000;
    var smartNoDelay = smartShareSettings.smartNoDelay;
    var openElements = document.querySelectorAll('.smart-popup-yes, .smart-popup-maybe');

    setTimeout(showPopupIfNeeded, smartDelay);

    openElements.forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: document.querySelector('link[rel=canonical]') ? document.querySelector('link[rel=canonical]').href : document.location.href
                });
            } else {
                var modal = document.getElementById('smartShareModal');

                setShareLinkUrl('facebookLink', 'https://www.facebook.com/sharer.php?u=' + encodeURIComponent(currentUrl));
                setShareLinkUrl('twitterLink', 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(currentUrl));
                setShareLinkUrl('pinterestLink', 'https://www.pinterest.com/pin/create/button/?url=' + encodeURIComponent(currentUrl));
                setShareLinkUrl('linkedinLink', 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(currentUrl));
                setShareLinkUrl('telegramLink', 'https://t.me/share/url?url=' + encodeURIComponent(currentUrl));
                setShareLinkUrl('whatsappLink', 'https://api.whatsapp.com/send?text=' + encodeURIComponent(currentUrl));

                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        });
    });

    document.getElementById('modalClose').addEventListener('click', function() {
        var modal = document.getElementById('smartShareModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    document.getElementById('copyButton').addEventListener('click', copyPageLink);

    function setShareLinkUrl(linkId, url) {
        var linkElement = document.getElementById(linkId);
        linkElement.href = url;
    }

    function copyPageLink() {
        var pageUrl = window.location.href;
        var tempInput = document.createElement('input');
        document.body.appendChild(tempInput);
        tempInput.value = pageUrl;
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        var button = document.getElementById('copyButton');
        button.innerHTML = button.dataset.copiedText;
        button.classList.add('copied');

        setTimeout(function() {
            button.innerHTML = button.dataset.copyText;
            button.classList.remove('copied');
        }, 2000);
    }


    function setCustomColors(smartBgColor, smartTextColor) {
        document.documentElement.style.setProperty('--smart-share-background', smartBgColor);
        document.documentElement.style.setProperty('--smart-text-color', smartTextColor);
    }

    function closePopupWithAnimation() {
        var popup = document.getElementById('smartPopupContainer');
        var fotozSmartShareIcon = document.getElementById('fotozSmartShareIcon');

        popup.classList.add('slide-out-bottom');

        fotozSmartShareIcon.style.display = 'block';
        fotozSmartShareIcon.style.animation = 'fadeInLeftToRight 0.5s ease-out forwards';

        setTimeout(function () {
            fotozSmartShareIcon.style.animation = 'none'; // Reset animation
        }, 500);

        // fotozSmartShareIcon.style.display = 'block';
        localStorage.setItem('smartPopupClosedTime', Date.now());
    }

    function showPopupIfNeeded() {
        var popup = document.getElementById('smartPopupContainer');
        var popupClosedTime = localStorage.getItem('smartPopupClosedTime');
        var currentTime = Date.now();
        var timeElapsed = currentTime - parseInt(popupClosedTime, 10);
        var timeBeforeShowingPopupAgain = smartNoDelay * 60 * 1000;

        if (!popupClosedTime || timeElapsed >= timeBeforeShowingPopupAgain) {
            popup.classList.add('show');
        } else {
            var fotozSmartShareIcon = document.getElementById('fotozSmartShareIcon');
            fotozSmartShareIcon.style.display = 'block';
            fotozSmartShareIcon.style.animation = 'fadeInLeftToRight 0.5s ease-out forwards';

            setTimeout(function () {
                fotozSmartShareIcon.style.animation = 'none';
            }, 500);
        }
    }

    var closeButton = document.querySelector('.smart-popup-no');

    if (closeButton) {
        closeButton.addEventListener('click', closePopupWithAnimation);
    }
    setCustomColors(smartBgColor, smartTextColor);

});

