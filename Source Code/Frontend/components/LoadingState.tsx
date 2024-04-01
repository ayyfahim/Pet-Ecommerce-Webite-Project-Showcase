export default function LoadingState() {
  // console.log('Loading..');
  // return <span>Loading..</span>;
  return (
    <div className="h-full w-screen fixed top-0 left-0 right-0 bottom-0 z-50 backdrop-blur-sm bg-slate-400/30">
      <div className="absolute right-1/2 bottom-1/2  transform translate-x-1/2 translate-y-1/2 ">
        <div className="border-t-transparent border-solid animate-spin  rounded-full border-indigo-600 border-8 h-16 w-16"></div>
      </div>
    </div>
  );
}
