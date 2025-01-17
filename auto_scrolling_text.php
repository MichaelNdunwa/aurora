<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
          "width=device-width, initial-scale=1.0">
    <title>Auto Scrolling with CSS</title>
</head>
<style>
    /* Horizontal Auto-Scrolling */
/* .marquee {
    overflow: hidden;
    white-space: nowrap;
    box-sizing: border-box;
    animation: marquee 20s linear infinite;
    border: 1px solid #000;
    background-color: rgb(198, 236, 198);
    padding: 10px;
    width: 100%;
} */

.marquee .scrolling-text {
    display: inline-block;
    /* padding-left: 100%; */
    animation: marquee 20s linear infinite;
    text-wrap: nowrap;
    overflow: hidden;
    white-space: nowrap;
}

@keyframes marquee {
    from {
        transform: translateX(100%);
    }
    to {
        transform: translateX(-100%);
    }
}

/* Pause on Hover */
.marquee scrolling-text:hover {
    animation-play-state: paused;
}
</style>
<body>
    <h1>Horizontal Auto-Scrolling Text</h1>
    <div class="marquee">
        <span class="scrolling-text">
            This is an auto-scrolling text created with CSS. Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis at ex dolorum a voluptate quo cum illo accusamus fugiat iusto aspernatur facere, quibusdam mollitia doloribus dicta molestias amet odio voluptas.
        </span>
    </div>
</body>
</html>