</div>

<footer>
    <p>&copy; <?= date('Y') ?> ПМ.09 УП Чувакина Влада 9-ИС203. Все права защищены.</p>
</footer>

<script src="/blog/assets/js/comments.js"></script>
<script src="/blog/assets/js/likes.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    const burger = document.getElementById("burger");
    const nav = document.getElementById("nav");

    burger.addEventListener("click", function(){
        nav.classList.toggle("active");
    });
});
</script>
</body>
</html>