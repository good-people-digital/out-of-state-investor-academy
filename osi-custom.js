jQuery(document).ready(function ($) {
  $(".wp-block-query .wp-block-post").each(function () {
    var $post = $(this);
    var $link = $post.find("a");
    var linkHref = $link.attr("href");

    // Wrap the existing content of .wp-block-post with the link
    $post.contents().wrapAll('<a href="' + linkHref + '" target="_self"></a>');
  });
});
