const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './views/**/*.blade.php',
    './assets/**/*.js',
    './assets/**/*.vue',
  ],
  safelist: [
    // Grid
    'sm:grid-cols-1',
    'sm:grid-cols-2',
    'sm:grid-cols-3',
    'sm:grid-cols-4',
    'sm:grid-cols-5',
    'sm:grid-cols-6',
    'sm:grid-cols-7',
    'sm:grid-cols-8',
    'md:grid-cols-1',
    'md:grid-cols-2',
    'md:grid-cols-3',
    'md:grid-cols-4',
    'md:grid-cols-5',
    'md:grid-cols-6',
    'md:grid-cols-7',
    'md:grid-cols-8',
    'lg:grid-cols-1',
    'lg:grid-cols-2',
    'lg:grid-cols-3',
    'lg:grid-cols-4',
    'lg:grid-cols-5',
    'lg:grid-cols-6',
    'lg:grid-cols-7',
    'lg:grid-cols-8',
    'xl:grid-cols-1',
    'xl:grid-cols-2',
    'xl:grid-cols-3',
    'xl:grid-cols-4',
    'xl:grid-cols-5',
    'xl:grid-cols-6',
    '2xl:grid-cols-1',
    '2xl:grid-cols-2',
    '2xl:grid-cols-3',
    '2xl:grid-cols-4',
    '2xl:grid-cols-5',
    '2xl:grid-cols-6',
    '2xl:grid-cols-7',
    '2xl:grid-cols-8',
    'md:items-end',
    '2xl:flex-row',

    'lg:gap-x-16',

    // Width
    'sm:w-6',
    'md:w-6',
    'lg:w-6',
    'xl:w-6',
    '2xl:w-6',
    'sm:w-fit',
    'md:w-fit',
    'lg:w-fit',
    'xl:w-fit',
    '2xl:w-3/4',
    '2xl:w-1/4',

    // Margin & paddings
    'mr-1',

    // Text
    'md:text-[18px]',
    'xl:text-xl',
    '2xl:text-xl',
    'sm:text-right',
    'md:text-right',
    'lg:text-right',
    'xl:text-right',
    'sm:text-left',
    'md:text-left',
    'lg:text-left',
    'xl:text-left',
    'sm:text-center',
    'md:text-center',
    'lg:text-center',
    'xl:text-center',

    // Border radius
    'rounded-[30px]',
    'sm:rounded-[30px]',
    'md:rounded-[30px]',
    'lg:rounded-[30px]',
    'xl:rounded-[30px]',
    'rounded-[50px]',
    'sm:rounded-[50px]',
    'md:rounded-[50px]',
    'lg:rounded-[50px]',
    'xl:rounded-[50px]',

    // Animations
    'group-hover:-translate-y-2',
    'group-hover:md:-translate-y-4',
  ],
  theme: {
    boxShadow: {
      sm: '0 1px 2px 0 rgba(0, 0, 0, 0.09)',
      DEFAULT: '0 1px 3px 0 rgba(0, 0, 0, 0.09), 0 1px 2px 0 rgba(0, 0, 0, 0.09)',
      md: '0 4px 6px -1px rgba(0, 0, 0, 0.09), 0 2px 4px -1px rgba(0, 0, 0, 0.09)',
      lg: '0 10px 15px -3px rgba(0, 0, 0, 0.09), 0 4px 6px -2px rgba(0, 0, 0, 0.09)',
      xl: '0 20px 25px -5px rgba(0, 0, 0, 0.09), 0 10px 10px -5px rgba(0, 0, 0, 0.09)',
      '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.09)',
      '3xl': '0 35px 60px -15px rgba(0, 0, 0, 0.09)',
      inner: 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.09)',
      none: 'none',
    },
    extend: {


      screens: {
        '3xl': '1920px',
      },

      colors: {
        DEFAULT: '#000000',
        primary: {
          light: 'var(--primary-color-light)',
          DEFAULT: 'var(--primary-color)',
          dark: 'var(--primary-color-dark)'
        },
        secondary: {
          light: 'var(--secondary-color-light)',
          DEFAULT: 'var(--secondary-color)',
          dark: 'var(--secondary-color-dark)'
        },
        tertiary: {
          light: 'var(--tertiary-color-light)',
          DEFAULT: 'var(--tertiary-color)',
          dark: 'var(--tertiary-color-dark)'
        },
        quaternary: {
          light: 'var(--quaternary-color-light)',
          DEFAULT: 'var(--quaternary-color)',
          dark: 'var(--quaternary-color-dark)'
        },
        background: {
          light: 'var(--background-color-light)',
          DEFAULT: 'var(--background-color)',
          dark: 'var(--background-color-dark)'
        },
        cta: {
          DEFAULT: 'var(--cta-color)',
        },
        basic: {
          success: 'var(--basic-color-success)',
          danger: 'var(--basic-color-danger)'
        },
        input: {
          background: '#F5F3F3',
          placeholder: '#a1a1a1'
        }
      },
      fontFamily: {
        sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
        head: ['Open Sans', ...defaultTheme.fontFamily.sans],
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
        '6xl':  ['4.5rem', theme('lineHeight.normal')],   // 72

          //Divide font by 16. Because 1 rem == 16px

          '21': ['1.3125rem', theme('lineHeight.normal')],
          '26': ['1.625rem', theme('lineHeight.normal')],
          '31': ['1.9375rem', theme('lineHeight.normal')],
          '36': ['2.25rem', theme('lineHeight.normal')],
          '41': ['2.5625rem', theme('lineHeight.normal')],
          '51': ['3.1875rem', theme('lineHeight.normal')],

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

