// Configure your Browserify bundles here
// 
// Each bundle config must be an object with two properties:
// 1. outputName:  (The filename for your bundle)
// 2. entries:     (An array containing the paths to the modules you want to include in your bundle)
//                 ('./' is relative to the '/js' directory)

module.exports = [
  {
    outputName: 'main.js',
    entries: [
      './modules/responsiveImages',
      './components/nav',
      './components/equal-height.js',
      './components/alert',
      './components/image-uploaders',
      './components/product-dropdowns',
      './components/product-filtering',
      './components/product-thumbnails',
      './components/scroll-to',
      './components/mask',
      './components/wpml-customizations',
      './lib/slick/slick',
      './modules/slider',
      './modules/detector-selector',
      './modules/product-compare'
    ]
  },
  {
    outputName: 'warranty-registration.js',
    entries: [
      './modules/warranty-registration'
    ]
  }
];
