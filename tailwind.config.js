const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './views/**/*.blade.php',
    './assets/**/*.js',
    './assets/**/*.vue',
  ],
  theme: {
    boxShadow: {
      sm: '0 1px 2px 0 rgba(0, 0, 0, 0.04)',
      DEFAULT: '0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px 0 rgba(0, 0, 0, 0.04)',
      md: '0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -1px rgba(0, 0, 0, 0.04)',
      lg: '0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.04)',
      xl: '0 20px 25px -5px rgba(0, 0, 0, 0.04), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
      '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.04)',
      '3xl': '0 35px 60px -15px rgba(0, 0, 0, 0.04)',
      inner: 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.04)',
      none: 'none',
    },
    extend: {
      colors: {
        DEFAULT: '#000000',
        primary: {
          light: '#000000',
          DEFAULT: '#000000',
          dark: '#000000'
        },
        secondary: {
          light: '#ea7039',
          DEFAULT: '#CE5827',
          dark: '#ac481e'
        },
        input: {
          background: '#F0F5FC',
          placeholder: '#D0D6DF'
        }
      },
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
        head: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
      fontSize: theme => ({
        'xs':   ['0.75rem', theme('lineHeight.normal')],  // 12
        'sm':   ['0.875rem', theme('lineHeight.normal')], // 14
        'base': ['1rem', theme('lineHeight.normal')],     // 16
        'md':   ['1.125rem', theme('lineHeight.normal')], // 18
        'lg':   ['1.25rem', theme('lineHeight.normal')],  // 20
        'xl':   ['1.5rem', theme('lineHeight.normal')],   // 24
        '2xl':  ['1.875rem', theme('lineHeight.normal')], // 30
        '3xl':  ['2.25rem', theme('lineHeight.normal')],  // 36
        '4xl':  ['3rem', theme('lineHeight.normal')],     // 48
        '5xl':  ['4rem', theme('lineHeight.normal')],     // 64
        '6xl':  ['4.5rem', theme('lineHeight.normal')]    // 72
      }),
      zIndex: {
        '1': '1',
        '2': '1',
        '3' : '3',
        '4' : '4',
        '5' : '5',
        '-1': '-1',
        '-2': '-1',
        '-3' : '-3',
        '-4' : '-4',
        '-5' : '-5',
        '-10': '-10',
        '-20': '-20',
        '-30': '-30',
        '-40': '-40',
      }
    },
  },

  variants: {
    extend: {
      opacity: ['disabled'],
      backgroundColor: ['checked'],
      borderColor: ['checked']
    },
  },

  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('tailwindcss-textshadow')
  ],

}

