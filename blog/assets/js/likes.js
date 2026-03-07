document.querySelectorAll(".like-btn").forEach(btn=>{
btn.addEventListener("click", async ()=>{
const id=btn.dataset.id;
await fetch("toggle_like.php",{
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"post_id="+id
});
location.reload();
});
});