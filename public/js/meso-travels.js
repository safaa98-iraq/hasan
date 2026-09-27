const header = document.querySelector("[data-header]");
const menuToggle = document.querySelector(".menu-toggle");
const navigation = document.querySelector(".site-nav");
const menuLabel = menuToggle?.querySelector(".sr-only");
const mobile = window.matchMedia("(max-width: 900px)");
const arabic = document.documentElement.lang === "ar";

// Blade renders the active language and its URLs together. Never replace link markup.
const setMenu = (open, restoreFocus = false) => {
  menuToggle?.setAttribute("aria-expanded", String(open));
  navigation?.classList.toggle("is-open", open);
  if (navigation) navigation.inert = mobile.matches && !open;
  document.body.style.overflow = open ? "hidden" : "";
  if (menuLabel) menuLabel.textContent = open
    ? (arabic ? "إغلاق القائمة" : "Close menu")
    : (arabic ? "فتح القائمة" : "Open menu");
  if (restoreFocus) menuToggle?.focus();
};

menuToggle?.addEventListener("click", () => {
  const open = menuToggle.getAttribute("aria-expanded") !== "true";
  setMenu(open);
  if (open) navigation?.querySelector("a")?.focus();
});

navigation?.querySelectorAll("a").forEach((link) => {
  link.addEventListener("click", () => setMenu(false));
});

document.addEventListener("keydown", (event) => {
  if (menuToggle?.getAttribute("aria-expanded") !== "true") return;
  if (event.key === "Escape") setMenu(false, true);
  if (event.key !== "Tab") return;
  const focusable = [...header.querySelectorAll("a[href], button:not([disabled])")];
  const first = focusable[0];
  const last = focusable[focusable.length - 1];
  if (event.shiftKey && document.activeElement === first) {
    event.preventDefault();
    last?.focus();
  } else if (!event.shiftKey && document.activeElement === last) {
    event.preventDefault();
    first?.focus();
  }
});

const setHeaderState = () => header?.classList.toggle("is-scrolled", window.scrollY > 28);
window.addEventListener("scroll", setHeaderState, { passive: true });
mobile.addEventListener("change", () => setMenu(false));
setMenu(false);
setHeaderState();
