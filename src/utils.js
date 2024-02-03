import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const calculateTimeAgo = (modifiedGmt) => {
  return dayjs(modifiedGmt).fromNow();
};

export { calculateTimeAgo }
