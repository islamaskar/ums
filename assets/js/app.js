/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
import $ from 'jquery';

import 'bootstrap';
import '@fortawesome/fontawesome-free/js/all';


if ($(".delete_link")){
  $(".delete_link").click(function(e){
    e.preventDefault();
    const result = confirm('Are you sure you want to delete this item?');
    if(result){
      $(e.target).closest("td,div").children('form').submit()
    }
  })
}
