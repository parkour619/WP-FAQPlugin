//to show on single.php or any page just add this code.

<style>

/* FAQ Accordion Styles */
.faq-accordion .faq-item {
    margin-bottom: 20px;
}

.faq-accordion .faq-question {
    background-color: #f4f4f4;
    color: #333;
    padding: 10px;
    margin: 0;
    cursor: pointer;
    position: relative;	font-size: 18px;
    line-height: 36px;
    font-weight: 500;
}

.fa-plus.accordion-icon, .fa-minus.accordion-icon {
    float: right;
}

.faq-accordion .faq-answer {
    font-size: 18px;
    line-height: 30px;
    padding: 10px;
    display: none;
    background-color: #f4f4f4; /* Set background color of answer to match question */
}

.faq-accordion .faq-item.active .faq-answer {
    display: block;
}
</style>

<div>
<?php
if ( is_single() && has_action( 'faq_single_post_content' ) ) {
	
    echo '<div class="faq-accordion">';?>
	<h3 class="article-share related-heading">FAQ's</h3>
    <?php display_faq_accordion();
    echo '</div>';
}
?>

		</div>


<!-- Add jQuery code for FAQ accordion -->
<script>
    jQuery(document).ready(function($) {
        // Initially hide all answer panels except the first one
        $('.faq-answer').not(':first').hide();

        // Show plus icons for all accordions except the first one
        $('.faq-item').not(':first').find('.fa-plus').show();

        // Toggle panel visibility and icons
        $('.faq-question').click(function() {
            var $panel = $(this).next('.faq-answer');
            
            // Toggle panel visibility
            $panel.slideToggle();

            // Toggle active class for the accordion
            $(this).parent('.faq-item').toggleClass('active').siblings('.faq-item').removeClass('active').find('.faq-answer').slideUp();

            // Toggle icons for the clicked accordion
            $(this).find('.fa-plus, .fa-minus').toggle();
            $(this).parent('.faq-item').siblings('.faq-item').find('.fa-minus').hide();
            $(this).parent('.faq-item').siblings('.faq-item').find('.fa-plus').show();
        });
    });
</script>
