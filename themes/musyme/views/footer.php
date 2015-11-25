        </div>
    </div>
<footer>
    <div id="footer-nav-list">
        <p>Copyright&nbsp;&copy;&nbsp;MUSY.me</p>
    </div>
</footer>
</div>

<script>
setInterval(function(){
    resizeCategories();
}, 200);

function updateItemCount(items)
{
    $('#itemCount').text(items);
}

function resizeCategories()
{
    $('.categoryItem').each(function(){
        $(this).height($(this).width());
        var look = $(this).find('.look');
        var margin = 0-look.height()/2;
        look.css('margin-top', margin);
    });
}
</script>

</body>
</html>