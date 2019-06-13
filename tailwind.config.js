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
  '128': '32rem',
  '256': '64rem',
}

module.exports = {
  theme: {
    extend: {
      borderRadius: {
        xl: '3rem',
        xxl: '6rem',
      },

      height: {
        'screen-30': '30vh',
        'screen-50': '50vh',
      },

      fontFamily: {
        logo: [
          'VT323',
          'monospace'
        ]
      },

      width: {
        '320': '320px',
        '380': '380px',
        '500': '500px',
      },

      inset: {
        ...customSpacing
      },

      minHeight: {
        ...customSpacing
      }
    }
  }
}