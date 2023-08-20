var frontend_block_accordion;(()=>{"use strict";var e={};(e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})})(e);const t={duration:400,easing:"cubic-bezier(0.2, 0.6, 0.4, 1)"};var n;window.stackableAccordion=new class{init=()=>{const e=window.matchMedia("(prefers-reduced-motion: reduce)").matches,n=!("ResizeObserver"in window)||e,o=new ResizeObserver((e=>e.forEach((e=>{const n=e.borderBoxSize[0].blockSize,o=e.target;if(o.dataset.height=n,o.doAnimate){o.doAnimate=!1;const e=o.dataset.preHeight;o.anim=o.animate({height:[`${e}px`,`${n}px`]},t),n-e>=0&&(o.contentEl.anim=o.contentEl.animate({maxHeight:["0px",n-e+"px"]},t))}})))),i=new MutationObserver((function(e){e.forEach((function(e){const t=e.target;if(t.anim&&t.anim.cancel(),t.contentEl.anim&&t.contentEl.anim.cancel(),t.classList[Array.from(t.classList).includes("stk--is-open")?"remove":"add"]("stk--is-open"),t.dataset.preHeight=t.dataset.height,n||(t.doAnimate=!0),t.open&&t.classList.contains("stk--single-open")){let e=t.nextElementSibling;for(;e&&e.classList.contains("stk-block-accordion");)e.open&&(e.open=!1),e=e.nextElementSibling;for(e=t.previousElementSibling;e&&e.classList.contains("stk-block-accordion");)e.open&&(e.open=!1),e=e.previousElementSibling}t.open&&t.getBoundingClientRect().top<0&&t.scrollIntoView({inline:"start",block:"start",behavior:"instant"})}))}));document.querySelectorAll(".stk-block-accordion").forEach((e=>{e.contentEl=e.querySelector(".stk-block-accordion__content"),n||o.observe(e),i.observe(e,{attributeFilter:["open"],attributeOldValue:!0})}))}},n=window.stackableAccordion.init,"undefined"!=typeof document&&("complete"!==document.readyState&&"interactive"!==document.readyState?document.addEventListener("DOMContentLoaded",n):n()),frontend_block_accordion=e})();