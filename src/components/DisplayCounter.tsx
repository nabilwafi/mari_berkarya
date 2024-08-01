import { RootState } from "../store/store";
import { useSelector } from "react-redux";

const DisplayCounter = () => {
  const count = useSelector((state: RootState) => state.counter.value);

  return (
    <div className="flex w-full justify-center my-5 items-center gap-5 text-5xl uppercase font-bold min-h-[80vh]">
      {count}
    </div>
  );
};

export default DisplayCounter;
