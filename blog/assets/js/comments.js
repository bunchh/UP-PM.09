document.getElementById("commentForm")?.addEventListener("submit", async function(e){
    e.preventDefault();

    const content = document.getElementById("content").value;
    const post_id = this.dataset.post;

    const res = await fetch("add_comment.php", {
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify({content,post_id})
    });

    const data = await res.json();

    document.getElementById("commentsList").innerHTML =
    `<div class="comment-card">
        <div class="comment-header">
            <strong>${data.name}</strong>
            <span class="comment-date">${data.created_at}</span>
        </div>
        <p>${data.content}</p>
     </div>` 
    + document.getElementById("commentsList").innerHTML;

    this.reset();
});