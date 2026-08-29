/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
    "./app/Http/**/*.php",
    "./app/Models/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#0F2F24",
        "primary-dark": "#0A1E17",
        secondary: "#1B4D3E",
        accent: "#C5A880",
        "accent-dark": "#9E8159",
        "accent-light": "#EFE8DE",
        "sage": "#407B64",
        "sage-light": "#E9F2EE",
        "neutral-body": "#4B5563",
        "neutral-bg": "#F8FAF9",
        "neutral-dark": "#0B1713",
      },
      fontFamily: {
        sans: ["'Plus Jakarta Sans'", "Inter", "system-ui", "-apple-system", "sans-serif"],
        display: ["'Plus Jakarta Sans'", "Inter", "sans-serif"],
      },
      letterSpacing: {
        widest2: "0.20em",
        widest3: "0.30em",
      },
      boxShadow: {
        'soft': '0 4px 20px -2px rgba(15, 47, 36, 0.06), 0 2px 6px -1px rgba(15, 47, 36, 0.04)',
        'elevated': '0 20px 25px -5px rgba(15, 47, 36, 0.08), 0 10px 10px -5px rgba(15, 47, 36, 0.04)',
        'glow': '0 0 25px rgba(197, 168, 128, 0.25)',
      },
    },
  },
  plugins: [],
}
