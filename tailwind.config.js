module.exports = {
  theme: {
    extend: {
      animation: {
        fadeInLeft: 'fadeInLeft 1s ease forwards',
        fadeInUp: 'fadeInUp 1s ease forwards',
        pulseSlow: 'pulse 2.5s ease-in-out infinite',
      },
      keyframes: {
        fadeInLeft: {
          '0%': { opacity: 0, transform: 'translateX(-20px)' },
          '100%': { opacity: 1, transform: 'translateX(0)' },
        },
        fadeInUp: {
          '0%': { opacity: 0, transform: 'translateY(20px)' },
          '100%': { opacity: 1, transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
}
