jQuery(document).ready(function ($) {
  $(".wp-block-query .wp-block-post").each(function () {
    var $post = $(this);
    var $link = $post.find("a");
    var linkHref = $link.attr("href");

    // Wrap the existing content of .wp-block-post with the link
    $post.contents().wrapAll('<a href="' + linkHref + '" target="_self"></a>');
  });

  $(".slider-3-items").slick({
    infinite: false,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
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
        breakpoint: 640,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });
});
