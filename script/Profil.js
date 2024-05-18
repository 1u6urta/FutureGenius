const dp = document.querySelector("#dp");
const cv = document.querySelector("#CV");
const ce = document.querySelector("#CE")

const Dip = document.querySelector("#Diplomes");
const CvS = document.querySelector("#CvS");
const Ces = document.querySelector("#CES");


dp.addEventListener("click", function() {
    dp.classList.toggle("active");
    Dip.classList.remove("hidden");
    CvS.classList.add("hidden");
    Ces.classList.add("hidden");
    cv.classList.remove("active");
    ce.classList.remove("active"); 
});

cv.addEventListener("click", function() {
    cv.classList.toggle("active");
    CvS.classList.remove("hidden");
    Dip.classList.add("hidden");
    Ces.classList.add("hidden");
    dp.classList.remove("active");
    ce.classList.remove("active"); 
});

ce.addEventListener("click", function() {
    ce.classList.toggle("active");
    Ces.classList.remove("hidden");
    CvS.classList.add("hidden");
    Dip.classList.add("hidden");
    cv.classList.remove("active");
    dp.classList.remove("active"); 
});
