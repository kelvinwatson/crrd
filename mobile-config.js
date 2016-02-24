App.accessRule("*");
App.accessRule('*.google.com/*');
App.accessRule('*.googleapis.com/*');
App.accessRule('*.gstatic.com/*');

App.info({
  name: 'Corvallis Reuse and Repair Directory',
  description: 'Corvallis Reuse Repair Directory, AWS Deploy',
  version: '0.0.2'
});

App.icons({
  'android_ldpi': 'resources/icons/icon-ldpi.png',
  'android_mdpi': 'resources/icons/icon-mdpi.png',
  'android_hdpi': 'resources/icons/icon-hdpi.png',
  'android_xhdpi': 'resources/icons/icon-xhdpi.png'
});
