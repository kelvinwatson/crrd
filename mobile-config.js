App.accessRule("*");
App.accessRule('*.google.com/*');
App.accessRule('*.googleapis.com/*');
App.accessRule('*.gstatic.com/*');

App.info({
  name: 'crrd',
  description: 'Corvallis Reuse Repair Directory',
  version: '0.0.1'
});

App.icons({
  'android_ldpi': 'resources/icons/icon-ldpi.png',
  'android_mdpi': 'resources/icons/icon-mdpi.png',
  'android_hdpi': 'resources/icons/icon-hdpi.png',
  'android_xhdpi': 'resources/icons/icon-xhdpi.png'
});
