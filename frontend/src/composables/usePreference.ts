import useUserStore from '../stores/user';

export default () => {
  const userStore = useUserStore();
  return userStore.findPreference;
};
