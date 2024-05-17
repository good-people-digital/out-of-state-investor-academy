jQuery(document).ready(function ($) {
  $(".wp-block-query .wp-block-post").each(function () {
    var $post = $(this);
    var $link = $post.find("a");
    var linkHref = $link.attr("href");

    // Wrap the existing content of .wp-block-post with the link
    $post.contents().wrapAll('<a href="' + linkHref + '" target="_self"></a>');
  });

  var svgArrowPrev =
    '<svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M40.4609 32C40.4609 32.7031 39.9141 33.25 39.25 33.25H27.2578L31.3594 37.3906C31.8672 37.8594 31.8672 38.6797 31.3594 39.1484C31.125 39.3828 30.8125 39.5 30.5 39.5C30.1484 39.5 29.8359 39.3828 29.6016 39.1484L23.3516 32.8984C22.8438 32.4297 22.8438 31.6094 23.3516 31.1406L29.6016 24.8906C30.0703 24.3828 30.8906 24.3828 31.3594 24.8906C31.8672 25.3594 31.8672 26.1797 31.3594 26.6484L27.2578 30.75H39.25C39.9141 30.75 40.4609 31.3359 40.4609 32Z" fill="#F5AC2B"/><rect x="1" y="1" width="62" height="62" rx="31" stroke="#F5AC2B" stroke-width="2"/></svg>';
  var svgArrowNext =
    '<svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M40.1094 32.8984L33.8594 39.1484C33.625 39.3828 33.3125 39.5 33 39.5C32.6484 39.5 32.3359 39.3828 32.1016 39.1484C31.5938 38.6797 31.5938 37.8594 32.1016 37.3906L36.2031 33.25H24.25C23.5469 33.25 23 32.7031 23 32C23 31.3359 23.5469 30.75 24.25 30.75H36.2031L32.1016 26.6484C31.5938 26.1797 31.5938 25.3594 32.1016 24.8906C32.5703 24.3828 33.3906 24.3828 33.8594 24.8906L40.1094 31.1406C40.6172 31.6094 40.6172 32.4297 40.1094 32.8984Z" fill="#F5AC2B"/><rect x="1" y="1" width="62" height="62" rx="31" stroke="#F5AC2B" stroke-width="2"/></svg>';

  $(".slider-3-items").slick({
    infinite: false,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 1318,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 980,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 670,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
    prevArrow:
      '<button type="button" class="slick-prev">' + svgArrowPrev + "</button>",
    nextArrow:
      '<button type="button" class="slick-next">' + svgArrowNext + "</button>",
  });

  $(".slider-1-item").slick({
    infinite: false,
    arrows: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    adaptiveHeight: false,
  });
});
