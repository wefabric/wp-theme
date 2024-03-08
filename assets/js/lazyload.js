document.addEventListener("DOMContentLoaded", function() {
    var lazyVideos = [].slice.call(document.querySelectorAll("video.lazy"));

    if ("IntersectionObserver" in window) {
        var lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var video = entry.target;
                    for (var source of video.children) {
                        if (source.tagName === "SOURCE" && source.dataset.src) {
                            source.src = source.dataset.src;
                        }
                    }
                    video.load();
                    video.classList.remove("lazy");
                    lazyVideoObserver.unobserve(video);
                }
            });
        });

        lazyVideos.forEach(function(lazyVideo) {
            lazyVideoObserver.observe(lazyVideo);
        });
    }
});
