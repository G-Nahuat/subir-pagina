document.addEventListener('DOMContentLoaded', function () {
  const slides = [
    { image: "/images/1920x700.webp", text: "Texto 1" },
    { image: "/images/EventoFotoPrueba.webp", text: "Texto 2" },
    { image: "/images/artesania1.webp", text: "Texto 3" }
  ];

  let index = 0;
  const bannerText = document.getElementById('bannerText');
  const bg1 = document.getElementById('heroBg1');
  const bg2 = document.getElementById('heroBg2');

  bg1.style.backgroundImage = `url('${slides[0].image}')`;
  bannerText.textContent = slides[0].text;

  setInterval(() => {
    const nextIndex = (index + 1) % slides.length;
    bg2.style.backgroundImage = `url('${slides[nextIndex].image}')`;
    bg2.style.opacity = 1;

    setTimeout(() => {
      bg1.style.backgroundImage = bg2.style.backgroundImage;
      bg2.style.opacity = 0;
      bannerText.textContent = slides[nextIndex].text;
      index = nextIndex;
    }, 1500);
  }, 5000);
});
