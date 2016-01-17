ReuseBusinesses = new Mongo.Collection('reuseBusinesses');
RepairBusinesses = new Mongo.Collection('repairBusinesses');
ReuseItemCategories = new Mongo.Collection('reuseItemCategories');
RepairItemCategories = new Mongo.Collection('repairItemCategories');
RecycleItemCategories = new Mongo.Collection('recycleItemCategories');

/*ItemCategories.insert({
  name: 'Books'
});*/
/*RepairBusinesses.insert({
  business_name: 'Book Binding',
  phone: 5417579861,
  street: '108 SW 3rd St',
  city: 'Corvallis',
  state: 'OR',
  country: 'US',
  zip: 97333,
  operating_hours: {
    Sun: { from: -1, to: -1},
    Mon: { from: 9, to: 17},
    Tue: { from: 9, to: 17},
    Wed: { from: 9, to: 17},
    Thu: { from: 9, to: 17},
    Fri: { from: 9, to: 17},
    Sat: { from: -1, to: -1}
  },
  website: "http://www.cornerstoneassociates.com/bj-bookbinding.html",
  latitude: 45.564466,
  longitude: -123.261360,
  items:['books']
});*/

if (Meteor.isClient) {
  /* Initialize ripple effect */
  Template.android.rendered = function(){
    $.material.init();
  };
  Template.admin.rendered = function(){
    $.material.init();
  };

  /**/

  Template.reuse_repair_recycle_panels.events({
    'click #reuse_panel': function(){
      Session.set('selectedAction','reuse');
      Router.go('/reuse');
    },
    'click #repair_panel': function(){
      Session.set('selectedAction','repair');
      Router.go('/repair');
    },
    'click #recycle_panel':function(){
      Session.set('selectedAction','recycle');
      Router.go('/recycle');
    }
  });

  Template.android_list_group.helpers({
    'title': function(){
      return Session.get('selectedAction')+" your item";
    },
    'items': function(){
      return this.repairItems;
    }
  });

  Template.android_list_group.events({
    'click .list-group-item': function(){
      console.log(this); //figure out what the object is that was clicked
      Router.go('/'+Session.get('selectedAction')+"?itemCat="+this.name);
    }
  });

  /*Session.setDefault('counter', 0);

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
  });*/


}

if (Meteor.isServer) {
  Meteor.startup(function () {
    // code to run on server at startup
  });
}
