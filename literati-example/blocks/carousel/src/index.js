import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl, Button } from '@wordpress/components';
import { useState } from '@wordpress/element';
import './style.scss';

registerBlockType('literati-example/promotion-carousel', {
    title: "Carousel Block",
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();
        const { transitionTimer } = attributes;
        const [inputInterval, setInputInterval] = useState(3000);


        return (
            <div>
                <TextControl
                    label="Set Transition Interval (ms)"
                    value={inputInterval}
                    id="interval-input"
                    onChange={(value) => setInputInterval(Number(value))}
                />
                <Button
                    isPrimary
                    id="interval-button"
                    onClick={() => setAttributes({ transitionTimer: inputInterval })}
                >
                    Update Interval
                </Button>
            </div>
        );
    },
    save: () => {
        return null;
    },
});

document.addEventListener('DOMContentLoaded', function() {

    var multipleCardCarousel = document.querySelector("#carouselExampleControls");

    if (window.matchMedia("(min-width: 768px)").matches) {
        var carousel = new bootstrap.Carousel(multipleCardCarousel, {
            interval: 3000,
            wrap: true
        });
        var carouselInner = document.querySelector(".carousel-inner");
        var carouselWidth = carouselInner.scrollWidth;
        var cards = document.querySelectorAll(".carousel-item");
        var cardWidth = cards[0].offsetWidth;
        var scrollPosition = 0;

        var nextButton = document.querySelector("#carouselExampleControls .carousel-control-next");
        var prevButton = document.querySelector("#carouselExampleControls .carousel-control-prev");

        nextButton.addEventListener("click", function () {
            if (scrollPosition < carouselWidth - cardWidth * 4) {
                scrollPosition += cardWidth;
                carouselInner.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            }
        });

        prevButton.addEventListener("click", function () {
            if (scrollPosition > 0) {
                scrollPosition -= cardWidth;
                carouselInner.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            }
        });

        var transitionInterval = 3000; 
        setInterval(function () {
            if (scrollPosition < carouselWidth - cardWidth * 4) {
                scrollPosition += cardWidth;
                carouselInner.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            } else {
                scrollPosition = 0;
                carouselInner.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            }
        }, transitionInterval);

        multipleCardCarousel.addEventListener('slide.bs.carousel', function (e) {
            cards.forEach(function (item) {
                item.classList.remove('active');
                item.style.transform = 'scale(0.9)';
            });

            var nextActiveItem = e.relatedTarget;
            nextActiveItem.style.transform = 'scale(1.05)';
        });
    } else {
         multipleCardCarousel.classList.add("slide");
    }

});

