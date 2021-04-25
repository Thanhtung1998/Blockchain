const IotDevice = artifacts.require("IotDevice");

module.exports = function (deployer) {
  deployer.deploy(IotDevice);
};
