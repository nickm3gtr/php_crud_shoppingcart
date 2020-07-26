module.exports = {
  transpileDependencies: ["vuetify"],
  devServer: {
    proxy: {
      "^/api": {
        target: process.env.VUE_APP_DEVSERVERPROXY
      },
      "^/oauth": {
        target: process.env.VUE_APP_DEVSERVERPROXY
      }
    }
  }
};
