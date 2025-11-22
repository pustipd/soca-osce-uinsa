// npm package: jquery-steps
// github link: https://github.com/rstaib/jquery-steps/

$(function() {
  'use strict';

  $("#wizard").steps({
    headerTag: "h2",
    bodyTag: "section",
    transitionEffect: "slideLeft"
  });
});
