// jQuery(document).ready(function ($) {
//   // Css Animation on scroll
//   $(".scroll-animate").each(function () {
//     var section = $(this);
//     var element = section.find(
//       ".is-style-double-underline-animated, .is-style-underline-animated"
//     );

//     $(window).scroll(function () {
//       var elementPosition = element.offset()?.top;
//       if (elementPosition === undefined) return;

//       var triggerPosition = $(window).height() * 0.1;
//       var scrollPosition = $(window).scrollTop();
//       var windowHeight = $(window).height();

//       if (scrollPosition + windowHeight > elementPosition + triggerPosition) {
//         element.addClass("animate");
//       } else {
//         element.removeClass("animate");
//       }
//     });
//   });
// });
