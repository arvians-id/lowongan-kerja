<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2020 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
    </div>
    <div class="footer-right">
        2.3.0
    </div>
</footer>
<script>
    $(document).ready(function() {
        $('.logout').click(function(event) {
            event.preventDefault();
            const href = $(this).attr('href');
            swal({
                    text: "Are you sure, you want to logout?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = href;
                    }
                });
        })
    })
</script>