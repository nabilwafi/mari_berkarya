import { decrement, increment } from "../store/slicers/counterSlicer";
import { RootState } from "../store/store";
import { useSelector, useDispatch } from "react-redux";

const ButtonCounter = () => {
  const count = useSelector((state: RootState) => state.counter.value);
  const dispatch = useDispatch();
  return (
    <div className="flex w-full justify-center my-5 items-center gap-5">
      <button
        className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        onClick={() => dispatch(increment())}
      >
        +
      </button>
      <div className="text-3xl">{count}</div>
      <button
        className="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
        onClick={() => dispatch(decrement())}
      >
        -
      </button>
    </div>
  );
};

export default ButtonCounter;
