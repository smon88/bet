theme: {
  extend: {
    animation: {
      'scroll-left': 'scroll-left 25s linear infinite',
      'scroll-right': 'scroll-right 25s linear infinite',
    },
    keyframes: {
      'scroll-left': {
        '0%': { transform: 'translateX(0)' },
        '100%': { transform: 'translateX(-50%)' },
      },
      'scroll-right': {
        '0%': { transform: 'translateX(-50%)' },
        '100%': { transform: 'translateX(0)' },
      },
    },
  },
}
