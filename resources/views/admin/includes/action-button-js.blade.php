<script>
    $('.action-dropdown-link').click(function(event){
        event.stopPropagation();
        let thisList = $(this).closest('.action-dropdown-menu');
        $('.action-dropdown-menu').not(thisList).removeClass('active');
        thisList.toggleClass('active');
    });
    $(".action-dropdown-menu").on("click", function (event) {
        event.stopPropagation();
    });

    $(document).on("click", function () {
        $(".action-dropdown-menu").removeClass('active');
    });
</script>