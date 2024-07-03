// show sub menu functionality | top header
  var currently_open = false;
  var currently_click_menu = '';
  var getScreenWith = getScreenWith=$(window).width();

  jQuery('.top-nav-links').click(function()
  {
    if((jQuery(this).hasClass('single-link')))
    {
      console.log(jQuery(this).find('a').attr('href'));
      window.location.href = jQuery(this).find('a').attr('href');
    }
    else if(!(jQuery(this).hasClass('tree-views')))
      return false;
    else
    {

      // // get the handler | id
      var current = jQuery(this);
      var id = jQuery(this).attr('id');
      currently_click_menu = "#"+id;

      // alert(currently_click_menu);

      if(jQuery(this).hasClass('active'))
      {
        jQuery('.content-fader').fadeToggle(300);
        currently_open = false;
        jQuery('.top-nav-wrap ul li, .sub-navs-wrapper').removeClass('active');
        return false;
      }
      else
      {
        jQuery('.single-link').removeClass('active');
        if(currently_open==true)
        {
          // alert('in');
          jQuery('.top-nav-wrap ul li, .sub-navs-wrapper').removeClass('active');

          setTimeout(function()
          {
            jQuery(current).toggleClass('active');
            jQuery('#sub-'+id).toggleClass('active');
          }, 600);
        }
        else
        {
          jQuery('.content-fader').fadeToggle(300);
          currently_open = true;
          // alert(currently_open);
          setTimeout(function()
          {
            jQuery(current).toggleClass('active');
            jQuery('#sub-'+id).toggleClass('active');
          }, 0);  
        }
      }
    }

  });

  jQuery('body').on('click','.content-fader',function()
    {
      jQuery(currently_click_menu).trigger('click');
    });

  var left = 0;

  jQuery( ".tree-views" ).each(function( index )
  {
    left = (getScreenWith > 767 && getScreenWith < 1199) ? 0 : 100;

    jQuery('#sub-'+jQuery( this ).attr('id') ).css('left', (jQuery('#'+jQuery( this ).attr('id') ).offset().left)-left+'px');

    jQuery('#sub-'+jQuery( this ).attr('id') ).css('top', (jQuery('#'+jQuery( this ).attr('id') ).offset().top)+90+'px');
    
  });


  jQuery(window).scroll(function() {
    var offset = jQuery(window).scrollTop();
    if(offset > 100)
    {
      // jQuery('.wrapper').addClass('get_sticky');
    }
    else
    {
      // jQuery('.wrapper').removeClass('get_sticky');
    }
  });
// show sub menu functionality | top header



//Disable Body Scroll on DialogBox/Modal
// jQuery('body').on('click','.custom-btn, .pickup_id_col, .confirm_single_pickup', function(){ jQuery('body').toggleClass('overflow-hidden') });

function removeOverflowHidden()
{
  // jQuery('body').toggleClass('overflow-hidden');
}
//Disable Body Scroll on DialogBox/Modal



// Modal Fade Effect
function contentFader()
{
  jQuery('.content-fader').toggleClass('front').fadeToggle(100);
}

// jQuery('.screen-loader').css('display', 'block');

// stagger animation for dashboard
jQuery(window).load(function()
{
  // jQuery('.screen-loader').velocity("stop").velocity("transition.shrinkOut", { stagger: 250 });

  // alert('sd');
  // TweenMax.staggerFrom(".box", 2, {x:-20, opacity:0, delay:.3, ease:Elastic.easeOut, force3D:true}, 0.1);
  jQuery('.dashboard-wrap').addClass('active');
  jQuery('.dashboard-wrap .stagger_aniamtion').velocity("stop").velocity("transition.expandIn", { stagger: 150 });

  setTimeout(function()
  {
    // jQuery('.screen-loader').removeAttr("style");
  }, 2000);
/*
  jQuery('.detailed-box .c-cells:not(.view-more)').click(function()
    {
      // jQuery(this).find('a').toggleClass('active');
      jQuery('.stagger-pop, .layer-popup-wrap .c-cells').velocity("stop").velocity("transition.slideUpIn", { stagger: 150 });
      // jQuery(this).parent().find('.num-khi a, .num-lhr a, .num-isb a').toggleClass('active');
    });
*/
  jQuery('.btn-close-popup').click(function()
  {
    jQuery('.layer-popup-wrap').velocity("stop").velocity("transition.shrinkOut", { duration: 550 });
  });

  jQuery('.toggle-dashboard').click(function()
  {

    if(jQuery(this).hasClass('toggled-on'))
    {
      jQuery(this).toggleClass('toggled-on');
      jQuery('.excerpt-box').css('display','none');
      jQuery('.lane-heading, .detailed-box').velocity("stop").velocity("transition.slideUpIn", { stagger: 150 });
    }
    else
    {
      jQuery(this).toggleClass('toggled-on');
      jQuery('.detailed-box').css('display','none');
      jQuery('.lane-heading, .excerpt-box').velocity("stop").velocity("transition.slideUpIn", { stagger: 150 });
    }
  });

});

  /*jQuery('document').ready(function()
  {

  });*/
// stagger animation for dashboard
