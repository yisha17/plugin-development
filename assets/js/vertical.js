const progressbar = document.querySelector("progress");
const article = document.querySelector("article");

let isScrolling = false;

document.addEventListener("scroll", (e) => (isScrolling = true));

render();
var body = document.body,
    html = document.documentElement;

var height = Math.max( body.scrollHeight, body.offsetHeight, 
                       html.clientHeight, html.scrollHeight, html.offsetHeight );

function render() {
  requestAnimationFrame(render);

  if (!isScrolling) return;

  progressbar.value =
    (window.scrollY / (height- window.innerHeight)) * 100;

  isScrolling = false;
}
