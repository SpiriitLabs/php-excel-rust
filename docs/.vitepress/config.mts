import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  base: '/',
  title: "Excel Rust",
  description: "Supercharge Excel generation in PHP with Rust's blazing speed!",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'PHP', link: '/php-readme' },
      { text: 'Symfony Bundle', link: '/symfony-bundle' },
      { text: 'Rust', link: '/rust-excel' }
    ],

    sidebar: [
      {
        text: 'PHP',
        items: [
          { text: 'Markdown Examples', link: '/markdown-examples' },
          { text: 'Runtime API Examples', link: '/api-examples' }
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/SpiriitLabs/php-excel-rust' }
    ]
  }
})
