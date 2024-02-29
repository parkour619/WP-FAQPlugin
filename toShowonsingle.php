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
}

.faq-accordion .faq-answer {
    padding: 10px;
    display: none;
}

.faq-accordion .faq-item.active .faq-answer {
    display: block;
}
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
    position: relative;
}

.faq-accordion .faq-answer {
    padding: 10px;
    display: none;
    background-color: #f4f4f4; /* Set background color of answer to match question */
}

.faq-accordion .faq-item.active .faq-answer {
    display: block;
}

/* Plus and minus icons */
.faq-accordion .faq-question::after {
    content: '+';
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
}

.faq-accordion .faq-question.active::after {
    content: '-';
}

</style>

<?php
if ( is_single() && has_action( 'faq_single_post_content' ) ) {
	
    echo '<div class="faq-accordion">';?>
	<h3 class="article-share related-heading">FAQ's</h3>
    <?php display_faq_accordion();
    echo '</div>';
}
?>


<!-- Add jQuery code for FAQ accordion -->
<script>
   jQuery(document).ready(function($) {
    // Toggle FAQ answer visibility
    $('.faq-question').click(function() {
        var $faqItem = $(this).parent('.faq-item');
        var $faqAnswer = $(this).next('.faq-answer');

        // Close other answers
        $('.faq-answer').not($faqAnswer).slideUp();
        $('.faq-item').not($faqItem).removeClass('active');

        // Toggle visibility of this answer
        $faqAnswer.slideToggle();

        // Toggle active class
        $faqItem.toggleClass('active');

        // Toggle plus and minus icons
        $(this).toggleClass('active');
    });
});

</script>
