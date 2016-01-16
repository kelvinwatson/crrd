Businesses = new Mongo.Collection('businesses');

/*Businesses.insert({business_category: 'repair',
  business_name: 'Book Binding',
  phone: 5417579861,
  street: '108 SW 3rd St',
  city: 'Corvallis',
  state: 'OR',
  country: 'US',
  zip: 97333,
  operating_hours: [],
  website: "www.cornerstoneassociates.com/bj-bookbinding-about-us.html",
  latitude: 45.564466,
  longitude: -123.261360,
  items:['books']});*/


if (Meteor.isClient) {
  /* Initialize ripple effect */
  Template.android.rendered = function(){
    $.material.init();
  };
  Template.admin.rendered = function(){
    $.material.init();
  };

  Session.setDefault('counter', 0);

  Template.hello.helpers({
    counter: function () {
      return Session.get('counter');
    }
  });

  Template.hello.events({
    'click button': function () {
      // increment the counter when button is clicked
      Session.set('counter', Session.get('counter') + 1);
    }
  });


}

if (Meteor.isServer) {
  Meteor.startup(function () {
    // code to run on server at startup
  });
}
