const Input = ({ placeholder, EndAdornment, ...props }) => {
    return (
        <div className="relative w-full">
            <input
                type="text"
                placeholder={placeholder}
                className="font-inter pr-12 w-full secondary-gradient border-none rounded-lg text-xl text-white placeholder:text-gray-300"
            />
            {EndAdornment && (
                <EndAdornment className="absolute right-4 top-1/2 -translate-y-1/2 text-white size-6" />
            )}
        </div>
    );
}

export default Input;
