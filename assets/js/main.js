const header=document.getElementById('siteHeader');
window.addEventListener('scroll',()=>header?.classList.toggle('scrolled',window.scrollY>20));
const navToggle=document.querySelector('.nav-toggle');
const mainNav=document.getElementById('mainNav');
navToggle?.addEventListener('click',()=>{mainNav.classList.toggle('open');navToggle.setAttribute('aria-expanded',mainNav.classList.contains('open')?'true':'false')});
document.querySelectorAll('.main-nav a').forEach(a=>a.addEventListener('click',()=>mainNav?.classList.remove('open')));
const observer=('IntersectionObserver'in window)?new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');observer.unobserve(e.target)}}),{threshold:.12}):null;
document.querySelectorAll('.feature-card,.product-card,.project-card,.testimonial,.split,.contact-card,.blog-card,.category-card,.detail-block').forEach(el=>{el.classList.add('reveal');observer?observer.observe(el):el.classList.add('visible')});
const searchInput=document.querySelector('[data-search]');
const filterBtns=document.querySelectorAll('[data-filter]');
const cards=document.querySelectorAll('[data-card]');
let activeFilter='all';
function applyFilters(){const q=(searchInput?.value||'').toLowerCase();cards.forEach(card=>{const text=card.textContent.toLowerCase();const cat=(card.dataset.category||'').toLowerCase();const tags=(card.dataset.tags||'').toLowerCase();const okText=text.includes(q)||tags.includes(q);const okFilter=activeFilter==='all'||cat===activeFilter||tags.split(' ').includes(activeFilter);card.classList.toggle('hidden',!(okText&&okFilter));});}
searchInput?.addEventListener('input',applyFilters);
filterBtns.forEach(btn=>btn.addEventListener('click',()=>{filterBtns.forEach(b=>b.classList.remove('active'));btn.classList.add('active');activeFilter=(btn.dataset.filter||'all').toLowerCase();applyFilters();}));
let quoteStep=0;const steps=[...document.querySelectorAll('.quote-steps .step')];const dots=[...document.querySelectorAll('.quote-steps .dot')];
function showStep(i){if(!steps.length)return;quoteStep=Math.max(0,Math.min(i,steps.length-1));steps.forEach((s,idx)=>s.classList.toggle('active',idx===quoteStep));dots.forEach((d,idx)=>d.classList.toggle('active',idx<=quoteStep));document.querySelector('[data-prev]')?.toggleAttribute('disabled',quoteStep===0);document.querySelector('[data-next]')?.classList.toggle('hidden',quoteStep===steps.length-1);document.querySelector('[data-submit]')?.classList.toggle('hidden',quoteStep!==steps.length-1);}
document.querySelector('[data-next]')?.addEventListener('click',()=>showStep(quoteStep+1));document.querySelector('[data-prev]')?.addEventListener('click',()=>showStep(quoteStep-1));showStep(0);
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        document.querySelector('.lightbox')?.classList.remove('open');
    }
});

let lightbox = document.querySelector('.lightbox');

function openLightbox(src, alt = 'Image') {
    if (!lightbox) {
        lightbox = document.createElement('div');
        lightbox.className = 'lightbox';

        lightbox.innerHTML = `
            <button type="button" aria-label="Close image">×</button>
            <img alt="">
        `;

        document.body.appendChild(lightbox);

        lightbox
            .querySelector('button')
            .addEventListener('click', function () {
                lightbox.classList.remove('open');
            });

        lightbox.addEventListener('click', function (event) {
            if (event.target === lightbox) {
                lightbox.classList.remove('open');
            }
        });
    }

    const lightboxImage = lightbox.querySelector('img');

    lightboxImage.src = src;
    lightboxImage.alt = alt;

    lightbox.classList.add('open');
}

document.addEventListener('click', function (event) {
    const trigger = event.target.closest('[data-lightbox]');

    if (!trigger) {
        return;
    }

    const image = trigger.matches('img')
        ? trigger
        : trigger.querySelector('img');

    const source =
        trigger.dataset.lightbox ||
        image?.dataset.lightbox ||
        image?.src;

    const alt =
        image?.alt ||
        trigger.getAttribute('aria-label') ||
        'Gallery image';

    if (!source) {
        return;
    }

    openLightbox(source, alt);
});

