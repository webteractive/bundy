const customSpacing = {
  '1': '0.25rem',
  '2': '0.5rem',
  '3': '0.75rem',
  '4': '1rem',
  '5': '1.25rem',
  '6': '1.5rem',
  '8': '2rem',
  '10': '2.5rem',
  '12': '3rem',
  '16': '4rem',
  '20': '5rem',
  '24': '6rem',
  '32': '8rem',
  '40': '10rem',
  '48': '12rem',
  '56': '14rem',
  '64': '16rem',
  '72': '24rem',
  '128': '32rem',
  '256': '64rem',
}

module.exports = {
  future: {},
  purge: {
    layers: ['components', 'utilities'],
    content: [
      './resources/**/*.html',
      './resources/**/*.vue',
      './resources/**/*.php',
    ]
  },
  theme: {
    screens: {
      'sm': '640px',
      'md': '768px',
      'lg': '980px',
      'xl': '1024px',
    },

    extend: {
      borderRadius: {
        xl: '3rem',
        xxl: '6rem',
      },

      height: {
        ...customSpacing,
        'screen-30': '30vh',
        'screen-50': '50vh',
      },

      fontFamily: {
        logo: [
          'VT323',
          'monospace'
        ],
        clock: [
          `Codystar`
        ]
      },

      width: {
        ...customSpacing,
        '240': '240px',
        '320': '320px',
        '380': '380px',
        '420': '420px',
        '500': '500px',
        '600': '600px',
        '800': '800px',
      },

      inset: {
        ...customSpacing
      },

      minHeight: {
        ...customSpacing
      },

      maxHeight: {
        '320': '320px'
      }
    }
  }
}